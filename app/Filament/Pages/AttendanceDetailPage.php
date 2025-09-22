<?php

namespace App\Filament\Pages;

use Carbon\Carbon;
use Filament\Pages\Page;
use App\Models\Attendance;
use Filament\Tables\Table;
use App\Models\StudentHistory;
use App\Models\AttendanceSchedule;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AttendanceScheduleOverride;
use Filament\Tables\Concerns\InteractsWithTable;

class AttendanceDetailPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.pages.attendance-detail-page';
    protected static ?string $title = 'Detail Presensi Siswa';
    
    public StudentHistory $student_history;

    public function mount(StudentHistory $student_history): void
    {
        $this->student_history = $student_history->load(['students', 'groups', 'academic_years']);
    }

    public function getTitle(): string
    {
        return 'Detail Presensi - ' . $this->student_history->students->name;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; 
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('check_in_time')
                    ->label('Tanggal & Waktu Masuk')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                
                TextColumn::make('check_out_time')
                    ->alignCenter()
                    ->label('Waktu Pulang')
                    ->dateTime('H:i')
                    ->sortable(),
                
                TextColumn::make('status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'late' => 'warning',
                        'missing' => 'danger',
                        'excused' => 'info',
                        'sick' => 'info',
                    })
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'present' => 'Hadir',
                            'late' => 'Terlambat',
                            'missing' => 'Tidak Presensi Pulang',
                            'excused' => 'Izin',
                            'sick' => 'Sakit',
                            default => ucfirst($state),
                        };
                    }),
                
                // TextColumn::make('reason')
                //     ->label('Alasan')
                //     ->limit(50)
                //     ->tooltip(function (TextColumn $column): ?string {
                //         $state = $column->getState();
                //         return strlen($state) > 50 ? $state : null;
                //     }),
                
                IconColumn::make('is_approved')
                    ->label('Persetujuan')
                    ->alignCenter()
                    ->boolean(),
                
                // TextColumn::make('note')
                //     ->label('Catatan')
                //     ->limit(30),
                
                // TextColumn::make('created_at')
                //     ->label('Dibuat')
                //     ->dateTime('d/m/Y H:i')
                //     ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Presensi')
                    ->options([
                        'present' => 'Hadir',
                        'late' => 'Terlambat',
                        'missing' => 'Tidak Presensi pulang',
                        'excused' => 'Izin',
                        'sick' => 'Sakit',
                    ]),
                
                SelectFilter::make('is_approved')
                    ->label('Status Persetujuan')
                    ->options([
                        '1' => 'Disetujui',
                        '0' => 'Menunggu Persetujuan',
                    ]),
                
                Filter::make('date_range')
                    ->form([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('from_date')
                                    ->label('Dari Tanggal'),
                                DatePicker::make('to_date')
                                    ->label('Sampai Tanggal'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('check_in_time', '>=', $date)
                            )
                            ->when(
                                $data['to_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('check_in_time', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        \Filament\Forms\Components\Grid::make(2)
                            ->schema([
                                \Filament\Forms\Components\DateTimePicker::make('check_in_time')
                                    ->label('Waktu Masuk')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $this->updateAttendanceStatusInEdit($state, $get('check_out_time'), $set, $get);
                                    }),

                                \Filament\Forms\Components\DateTimePicker::make('check_out_time')
                                    ->label('Waktu Keluar')
                                    ->after('check_in_time')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $this->updateAttendanceStatusInEdit($get('check_in_time'), $state, $set, $get);
                                    }),
                            ]),

                        // Select khusus untuk Izin dan Sakit saja
                        \Filament\Forms\Components\Select::make('manual_status')
                            ->label('Status Khusus (Opsional)')
                            ->options([
                                'excused' => 'Izin',
                                'sick' => 'Sakit',
                            ])
                            ->placeholder('Pilih jika siswa izin/sakit')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $set('status', $state);
                                    $set('is_approved', false); // Perlu approval untuk izin/sakit
                                } else {
                                    // Kembalikan ke status otomatis
                                    $this->updateAttendanceStatusInEdit(
                                        $get('check_in_time'),
                                        $get('check_out_time'),
                                        $set,
                                        $get
                                    );
                                }
                            })
                            ->dehydrated(false), // Tidak disimpan ke database

                        // Hidden field untuk status yang sebenarnya
                        \Filament\Forms\Components\Hidden::make('status'),

                        // Preview status yang akan tersimpan
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
                                    default => '➖ Status tidak valid'
                                };
                            }),

                        // Alasan - wajib untuk izin/sakit
                        \Filament\Forms\Components\Textarea::make('reason')
                            ->label('Alasan')
                            ->required(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->visible(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->rows(3)
                            ->placeholder('Jelaskan alasan izin/sakit...'),

                        // File upload untuk izin/sakit
                        \Filament\Forms\Components\FileUpload::make('file')
                            ->downloadable()
                            ->label('File Pendukung (Surat Izin/Keterangan Dokter)')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize(2048)
                            ->visible(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->directory('attendance-files')
                            ->disk('public'),

                        // Toggle approval - disabled untuk izin/sakit
                        \Filament\Forms\Components\Toggle::make('is_approved')
                            ->label('Persetujuan')
                            // ->disabled(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->helperText('Otomatis disetujui kecuali untuk izin/sakit'),

                        // Catatan admin - hanya muncul jika tidak approved
                        \Filament\Forms\Components\Textarea::make('note')
                            ->label('Catatan Admin')
                            // ->visible(fn (callable $get) => !$get('is_approved'))
                            ->rows(2)
                            ->placeholder('Catatan untuk review...'),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        // Hapus manual_status sebelum save
                        unset($data['manual_status']);
                        return $data;
                    })
                    ->after(function ($record) {
                        Notification::make()
                            ->title('Presensi berhasil diperbarui')
                            ->body('Status: ' . $this->getStatusLabel($record->status))
                            ->success()
                            ->send();
                    }),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Presensi')
                    ->modalDescription(fn ($record) => "Apakah Anda yakin ingin menghapus presensi ini?\n\nData yang dihapus tidak dapat dikembalikan.")
                    ->after(function () {
                        Notification::make()
                            ->title('Presensi berhasil dihapus')
                            ->success()
                            ->send();
                    }),
            ])
            ->headerActions([
                Action::make('back')
                    ->label('Kembali')
                    ->icon('heroicon-m-arrow-left')
                    ->url(route('filament.admin.pages.attendance'))
                    ->color('gray'),

                Action::make('create_attendance')
                    ->label('Tambah Presensi')
                    ->icon('heroicon-m-plus')
                    ->color('primary')
                    ->modal()  
                    ->form([
                        \Filament\Forms\Components\Grid::make(2)
                            ->schema([
                                \Filament\Forms\Components\DateTimePicker::make('check_in_time')
                                    ->label('Waktu Masuk')
                                    ->required()
                                    ->default(now())
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $this->updateAttendanceStatusInCreate($state, $get('check_out_time'), $set, $get);
                                    }),
                
                                \Filament\Forms\Components\DateTimePicker::make('check_out_time')
                                    ->label('Waktu Keluar')
                                    ->after('check_in_time')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $this->updateAttendanceStatusInCreate($get('check_in_time'), $state, $set, $get);
                                    }),
                            ]),
                
                        // Select khusus untuk Izin dan Sakit saja
                        \Filament\Forms\Components\Select::make('manual_status')
                            ->label('Status Khusus (Opsional)')
                            ->options([
                                'excused' => 'Izin',
                                'sick' => 'Sakit',
                            ])
                            ->placeholder('Pilih jika siswa izin/sakit')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $set('status', $state);
                                    $set('is_approved', false);
                                } else {
                                    $this->updateAttendanceStatusInCreate(
                                        $get('check_in_time'),
                                        $get('check_out_time'),
                                        $set,
                                        $get
                                    );
                                }
                            })
                            ->dehydrated(false),
                
                        // Hidden fields
                        \Filament\Forms\Components\Hidden::make('status')->default('present'),
                        \Filament\Forms\Components\Hidden::make('student_history_id')->default($this->student_history->id),
                
                        // Status preview dengan emoji
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
                
                        // Conditional fields untuk izin/sakit
                        \Filament\Forms\Components\Textarea::make('reason')
                            ->label('Alasan')
                            ->required(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->visible(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->rows(3),
                
                        \Filament\Forms\Components\FileUpload::make('file')
                            ->label('File Pendukung')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize(2048)
                            ->visible(fn (callable $get) => in_array($get('status'), ['excused', 'sick']))
                            ->directory('attendance-files')
                            ->disk('public'),
                
                        \Filament\Forms\Components\Toggle::make('is_approved')
                            ->label('Persetujuan Otomatis')
                            ->default(true)
                            ->disabled(fn (callable $get) => in_array($get('status'), ['excused', 'sick'])),
                
                        \Filament\Forms\Components\Textarea::make('note')
                            ->label('Catatan Admin')
                            ->visible(fn (callable $get) => !$get('is_approved'))
                            ->rows(2),
                    ])
                    ->action(function (array $data) {
                        // Hapus manual_status dari data
                        unset($data['manual_status']);
                        
                        // Check duplikasi presensi
                        $existingAttendance = Attendance::where('student_history_id', $data['student_history_id'])
                            ->whereDate('check_in_time', Carbon::parse($data['check_in_time'])->toDateString())
                            ->exists();
                
                        if ($existingAttendance) {
                            Notification::make()
                                ->title('Presensi sudah ada!')
                                ->body('Siswa sudah memiliki presensi untuk tanggal ini.')
                                ->danger()
                                ->send();
                            return false; // Prevent modal closing
                        }
                
                        // Create attendance
                        Attendance::create($data);
                
                        Notification::make()
                            ->title('Presensi berhasil dibuat!')
                            ->body('Status: ' . $this->getStatusLabel($data['status']))
                            ->success()
                            ->send();
                
                        // Refresh table
                        $this->resetTable();
                    })
                    ->modalHeading('Tambah Presensi Baru')
                    ->modalDescription('Buat presensi untuk siswa: ' . $this->student_history->students->name)
                    ->modalSubmitActionLabel('Simpan')
                    ->modalWidth('3xl'),
                // Action::make('create_attendance')
                //     ->label('Tambah Presensi')
                //     ->icon('heroicon-m-plus')
                //     ->color('primary')
                //     ->url(route('filament.admin.pages.create-attendance', ['student_history' => $this->student_history->id])),
            ])
            ->defaultSort('check_in_time', 'desc')
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(25);
    }

    /**
     * Update attendance status saat edit berdasarkan waktu masuk dan pulang
     */
    private function updateAttendanceStatusInEdit($checkInTime, $checkOutTime, callable $set, callable $get): void
    {
        // Jika ada manual status (izin/sakit), jangan update
        if ($get('manual_status')) {
            return;
        }

        if (!$checkInTime) {
            return;
        }

        $checkInCarbon = Carbon::parse($checkInTime);
        $checkOutCarbon = $checkOutTime ? Carbon::parse($checkOutTime) : null;

        // Get schedule untuk hari tersebut
        $schedule = $this->getScheduleForDateInEdit($checkInCarbon);
        
        if (!$schedule) {
            $set('status', 'present');
            $set('is_approved', true);
            return;
        }

        // Determine status berdasarkan waktu
        $status = $this->determineStatusByTimeInEdit($checkInCarbon, $checkOutCarbon, $schedule);
        
        $set('status', $status);
        $set('is_approved', true); // Auto approve untuk status berdasarkan waktu
    }


    private function updateAttendanceStatusInCreate($checkInTime, $checkOutTime, callable $set, callable $get): void
    {
        // Jika ada manual status (izin/sakit), jangan update
        if ($get('manual_status')) {
            return;
        }

        if (!$checkInTime) {
            return;
        }

        $checkInCarbon = Carbon::parse($checkInTime);
        $checkOutCarbon = $checkOutTime ? Carbon::parse($checkOutTime) : null;

        // Get schedule untuk hari tersebut
        $schedule = $this->getScheduleForDateInEdit($checkInCarbon);
        
        if (!$schedule) {
            $set('status', 'present');
            $set('is_approved', true);
            return;
        }

        // Determine status berdasarkan waktu
        $status = $this->determineStatusByTimeInEdit($checkInCarbon, $checkOutCarbon, $schedule);
        
        $set('status', $status);
        $set('is_approved', true);
    }
    /**
     * Get schedule untuk tanggal tertentu (check override dulu, lalu schedule normal)
     */
    private function getScheduleForDateInEdit(Carbon $date): ?object
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
    private function determineStatusByTimeInEdit(Carbon $checkIn, ?Carbon $checkOut, object $schedule): string
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

    /**
     * Get status label untuk display
     */
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

    protected function getTableQuery(): Builder
    {
        return Attendance::query()
            ->where('student_history_id', $this->student_history->id)
            ->orderBy('check_in_time', 'desc');
    }

    protected function getViewData(): array
    {
        $attendanceStats = $this->student_history->attendances()
            ->selectRaw('
                status,
                COUNT(*) as count,
                COUNT(CASE WHEN is_approved = 1 THEN 1 END) as approved_count
            ')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $totalAttendance = array_sum($attendanceStats);
        
        return [
            'student_history' => $this->student_history,
            'attendanceStats' => $attendanceStats,
            'totalAttendance' => $totalAttendance,
        ];
    }
}