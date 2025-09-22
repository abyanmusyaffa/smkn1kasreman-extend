<?php

namespace App\Filament\Pages;

use App\Models\StudentHistory;
use App\Models\Attendance;
use App\Models\AttendanceSchedule;
use App\Models\AttendanceScheduleOverride;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Carbon\Carbon;

class CreateAttendancePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.create-attendance-page';
    protected static ?string $title = 'Presensi Manual';

    public ?array $data = [];
    public ?StudentHistory $student_history = null;

    public function mount(?StudentHistory $student_history = null): void
    {
        if ($student_history) {
            $this->student_history = $student_history->load(['students', 'groups', 'academic_years']);
            $this->data['student_history_id'] = $student_history->id;
            $this->data['is_approved'] = true; // Default approved untuk siswa yang sudah dipilih
        }
        
        $this->form->fill($this->data);
    }

    public function getTitle(): string
    {
        if ($this->student_history) {
            return 'Buat Presensi Manual - ' . $this->student_history->students->name;
        }
        return 'Buat Presensi Manual';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; 
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Hidden student_history_id jika siswa sudah dipilih
                Hidden::make('student_history_id')
                    ->visible(fn () => $this->student_history !== null),

                // Section untuk pilih siswa (hanya muncul jika belum ada siswa)
                Section::make('Data Siswa')
                    ->schema([
                        Select::make('student_history_id')
                            ->label('Pilih Siswa')
                            ->options(function () {
                                return StudentHistory::with(['students', 'groups', 'academic_years'])
                                    ->where('status', 'active')
                                    ->get()
                                    ->mapWithKeys(function ($history) {
                                        return [
                                            $history->id => $history->student->name . ' - ' . 
                                                          $history->group?->name . ' - ' . 
                                                          $history->academicYear?->name
                                        ];
                                    });
                            })
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $this->student_history = StudentHistory::with(['students', 'groups', 'academic_years'])
                                        ->find($state);
                                    
                                    // Set default approved to true untuk siswa baru dipilih
                                    $set('is_approved', true);
                                }
                            }),
                    ])
                    ->columns(1)
                    ->visible(fn () => $this->student_history === null),

                Section::make('Data Presensi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('check_in_time')
                                    ->label('Waktu Masuk')
                                    ->required()
                                    ->default(now())
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $this->updateAttendanceStatus($state, $get('check_out_time'), $set);
                                    }),

                                DateTimePicker::make('check_out_time')
                                    ->label('Waktu Keluar')
                                    ->after('check_in_time')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $this->updateAttendanceStatus($get('check_in_time'), $state, $set);
                                    }),
                            ]),

                        // Select hanya untuk Izin dan Sakit, status lainnya otomatis berdasarkan waktu
                        Select::make('manual_status')
                            ->label('Status Khusus (Opsional)')
                            ->options([
                                'excused' => 'Izin',
                                'sick' => 'Sakit',
                            ])
                            ->placeholder('Pilih jika siswa izin/sakit')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('status', $state);
                                    $set('is_approved', false); // Perlu approval untuk izin/sakit
                                } else {
                                    // Kembalikan ke status otomatis
                                    $this->updateAttendanceStatus(
                                        $this->data['check_in_time'] ?? null,
                                        $this->data['check_out_time'] ?? null,
                                        $set
                                    );
                                }
                            }),

                        // Hidden field untuk status yang sebenarnya
                        Hidden::make('status')
                            ->default('present'),

                        // Tampilkan status yang akan tersimpan (readonly)
                        \Filament\Forms\Components\Placeholder::make('current_status')
                            ->label('Status yang Akan Tersimpan')
                            ->content(function (callable $get) {
                                $status = $get('status');
                                return match($status) {
                                    'present' => '✅ Hadir',
                                    'late' => '⏰ Terlambat',
                                    'missing' => '❌ Tidak Presensi Pulang',
                                    'excused' => '📋 Izin',
                                    'sick' => '🏥 Sakit',
                                    default => '➖ Belum Ditentukan'
                                };
                            }),

                        // Alasan wajib untuk izin/sakit
                        Textarea::make('reason')
                            ->label('Alasan')
                            ->required(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->visible(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->rows(3)
                            ->placeholder('Jelaskan alasan izin/sakit...'),

                        // File pendukung untuk izin/sakit
                        FileUpload::make('file')
                            ->downloadable()
                            ->label('File Pendukung (Surat Izin/Keterangan Dokter)')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize(2048)
                            ->visible(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->directory('attendance-files')
                            ->disk('public')
                            ->helperText('Upload surat izin atau keterangan dokter (format: JPG, PNG, PDF, max 2MB)'),

                        // Auto-approve toggle
                        Toggle::make('is_approved')
                            ->label('Persetujuan Otomatis')
                            ->disabled(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->helperText('Otomatis disetujui untuk status Hadir/Terlambat/Tidak Presensi Pulang. Izin/Sakit memerlukan persetujuan manual.'),

                        // Catatan admin hanya jika tidak approved
                        Textarea::make('note')
                            ->label('Catatan Admin')
                            ->visible(fn (callable $get) => !$get('is_approved'))
                            ->rows(2)
                            ->placeholder('Catatan untuk review persetujuan...'),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    /**
     * Update attendance status berdasarkan waktu masuk dan pulang
     */
    private function updateAttendanceStatus($checkInTime, $checkOutTime, callable $set): void
    {
        if (!$checkInTime) {
            return;
        }

        $checkInCarbon = Carbon::parse($checkInTime);
        $checkOutCarbon = $checkOutTime ? Carbon::parse($checkOutTime) : null;

        // Get schedule untuk hari tersebut
        $schedule = $this->getScheduleForDate($checkInCarbon);
        
        if (!$schedule) {
            $set('status', 'present');
            $set('is_approved', true);
            return;
        }

        // Determine status berdasarkan waktu
        $status = $this->determineStatusByTime($checkInCarbon, $checkOutCarbon, $schedule);
        
        $set('status', $status);
        $set('is_approved', true); // Auto approve untuk status berdasarkan waktu
    }

    /**
     * Get schedule untuk tanggal tertentu (check override dulu, lalu schedule normal)
     */
    private function getScheduleForDate(Carbon $date): ?object
    {
        // Check override dulu
        $override = AttendanceScheduleOverride::whereDate('date', $date->toDateString())->first();
        if ($override) {
            return $override;
        }

        // Fallback ke schedule normal
        $dayName = strtolower($date->format('l'));
        return AttendanceSchedule::where('day', $dayName)->first();
    }

    /**
     * Tentukan status berdasarkan waktu masuk dan keluar
     */
    private function determineStatusByTime(Carbon $checkIn, ?Carbon $checkOut, object $schedule): string
    {
        $checkInTime = $checkIn->format('H:i:s');
        $scheduleCheckInEnd = Carbon::parse($schedule->check_in_end)->format('H:i:s');

        // Cek apakah terlambat masuk
        $isLate = $checkInTime > $scheduleCheckInEnd;

        // Jika tidak ada waktu pulang
        if (!$checkOut) {
            return $isLate ? 'late' : 'missing'; // Terlambat + tidak presensi pulang, atau hanya tidak presensi pulang
        }

        // Jika ada waktu pulang
        return $isLate ? 'late' : 'present';
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Presensi')
                ->color('primary')
                ->action('create'),
            
            Action::make('cancel')
                ->label('Batal')
                ->color('gray')
                ->url(route('filament.admin.pages.attendance')),
        ];
    }

    public function create(): void
    {
        try {
            $data = $this->form->getState();
            
            // Remove manual_status dari data yang akan disimpan
            unset($data['manual_status']);
            
            // Validate that the student doesn't already have attendance for this date
            $existingAttendance = Attendance::where('student_history_id', $data['student_history_id'])
                ->whereDate('check_in_time', Carbon::parse($data['check_in_time'])->toDateString())
                ->exists();

            if ($existingAttendance) {
                Notification::make()
                    ->title('Presensi sudah ada!')
                    ->body('Siswa sudah memiliki presensi untuk tanggal ini.')
                    ->danger()
                    ->send();
                
                throw new Halt();
            }

            // Create the attendance record
            Attendance::create($data);

            Notification::make()
                ->title('Presensi berhasil dibuat!')
                ->body('Data presensi telah tersimpan dengan status: ' . $this->getStatusLabel($data['status']))
                ->success()
                ->send();

            // Redirect ke halaman yang sesuai
            if ($this->student_history) {
                $this->redirect("/admin/attendance/detail/{$this->student_history->id}");
            } else {
                $this->redirect('/admin/attendance');
            }

        } catch (Halt $exception) {
            return;
        }
    }

    private function getStatusLabel(string $status): string
    {
        return match($status) {
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'missing' => 'Tidak Presensi Pulang',
            'excused' => 'Izin',
            'sick' => 'Sakit',
            default => ucfirst($status)
        };
    }

    protected function getViewData(): array
    {
        return [
            'student_history' => $this->student_history,
        ];
    }
}