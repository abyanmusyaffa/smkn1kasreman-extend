<?php

namespace App\Filament\Pages;

use App\Models\StudentHistory;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Models\Group;
use App\Models\AttendanceSchedule;
use App\Models\AttendanceScheduleOverride;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class CreateClassAttendancePage extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static string $view = 'filament.pages.create-class-attendance-page';
    protected static ?string $title = 'Presensi Per Kelas';

    public ?array $data = [];
    public ?int $selectedGroupId = null;
    public ?int $selectedAcademicYearId = null;
    public ?string $selectedDate = null;

    public function mount(): void
    {
        $this->data = [
            'academic_year_id' => AcademicYear::where('is_active', true)->first()?->id,
            'group_id' => null,
            'attendance_date' => now()->toDateString(),
        ];
        $this->form->fill($this->data);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; 
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter Kelas')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('academic_year_id')
                                    ->label('Tahun Ajaran')
                                    ->options(
                                        AcademicYear::all()->mapWithKeys(fn ($record) => [
                                            $record->id => "{$record->name} - " . ($record->semester == 1 ? 'Ganjil' : 'Genap')
                                        ])
                                    )
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state) {
                                        $this->selectedAcademicYearId = $state;
                                        $this->selectedGroupId = null;
                                        $this->data['group_id'] = null;
                                        $this->resetTable();
                                    }),

                                Select::make('group_id')
                                    ->label('Kelas')
                                    ->options(function ($get) {
                                        $academicYearId = $get('academic_year_id');
                                        if (!$academicYearId) return [];
                                        
                                        return Group::whereHas('student_histories', function ($query) use ($academicYearId) {
                                            $query->where('academic_year_id', $academicYearId)
                                                  ->where('status', 'active');
                                        })->pluck('name', 'id');
                                    })
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function ($state) {
                                        $this->selectedGroupId = $state;
                                        $this->resetTable();
                                        $this->checkExistingAttendance();
                                    }),

                                DatePicker::make('attendance_date')
                                    ->label('Tanggal Presensi')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state) {
                                        $this->selectedDate = $state;
                                        $this->checkExistingAttendance();
                                    }),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('students.nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('students.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                // SelectColumn::make('temp_status')
                //     ->label('Status Presensi')
                //     ->options([
                //         'present' => 'Hadir',
                //         'late' => 'Terlambat', 
                //         'missing' => 'Tidak Presensi Pulang',
                //     ])
                //     ->selectablePlaceholder(false)
                //     ->default('present')
                //     ->updateStateUsing(function ($record, $state) {
                //         $this->createOrUpdateAttendance($record, $state);
                //         return $state;
                //     }),

                TextColumn::make('existing_status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $existing = $this->getExistingAttendance($record);
                        return $existing ? $this->getStatusLabel($existing->status) : 'Belum Ada';
                    })
                    ->color(function ($state) {
                        return match($state) {
                            'Hadir' => 'success',
                            'Terlambat' => 'warning',
                            'Tidak Presensi Pulang' => 'danger',
                            default => 'gray'
                        };
                    }),
            ])
            ->headerActions([
                Action::make('back')
                    ->label('Kembali')
                    ->icon('heroicon-m-arrow-left')
                    ->color('gray')
                    ->action(function () {
                        $this->redirect('/admin/attendance');
                    }),
            ])
            ->bulkActions([
                BulkAction::make('set_present')
                    ->label('Set Hadir')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->action(function (Collection $records) {
                        $this->bulkUpdateAttendance($records, 'present');
                    }),

                BulkAction::make('set_late')
                    ->label('Set Terlambat')
                    ->icon('heroicon-m-clock')
                    ->color('warning')
                    ->action(function (Collection $records) {
                        $this->bulkUpdateAttendance($records, 'late');
                    }),

                BulkAction::make('set_missing')
                    ->label('Set Tidak Presensi Pulang')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->action(function (Collection $records) {
                        $this->bulkUpdateAttendance($records, 'missing');
                    }),

                BulkAction::make('delete_attendance')
                    ->label('Hapus Presensi')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Presensi')
                    ->modalDescription('Apakah Anda yakin ingin menghapus presensi siswa yang dipilih?')
                    ->action(function (Collection $records) {
                        $this->bulkDeleteAttendance($records);
                    }),
            ])
            ->emptyStateHeading('Pilih Kelas dan Tanggal')
            ->emptyStateDescription('Silahkan pilih tahun ajaran, kelas, dan tanggal terlebih dahulu untuk menampilkan daftar siswa.')
            ->striped()
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25);
    }

    protected function getTableQuery(): Builder
    {
        if (!$this->selectedGroupId || !$this->selectedAcademicYearId) {
            return StudentHistory::query()->whereRaw('1 = 0'); // Empty query
        }

        return StudentHistory::query()
            ->with(['students'])
            ->where('group_id', $this->selectedGroupId)
            ->where('academic_year_id', $this->selectedAcademicYearId)
            ->where('status', 'active')
            ->orderBy('student_id');
    }

    private function getExistingAttendance($studentHistory): ?Attendance
    {
        if (!$this->selectedDate) return null;

        return Attendance::where('student_history_id', $studentHistory->id)
            ->whereDate('check_in_time', $this->selectedDate)
            ->first();
    }

    private function createOrUpdateAttendance($studentHistory, string $status): void
    {
        if (!$this->selectedDate) {
            Notification::make()
                ->title('Tanggal tidak valid!')
                ->danger()
                ->send();
            return;
        }

        $attendanceDate = Carbon::parse($this->selectedDate);
        $schedule = $this->getScheduleForDate($attendanceDate);

        // Check if attendance already exists
        $existingAttendance = $this->getExistingAttendance($studentHistory);

        // Generate times based on status and schedule
        [$checkInTime, $checkOutTime] = $this->generateAttendanceTimes($attendanceDate, $status, $schedule);

        if ($existingAttendance) {
            // Update existing attendance
            $existingAttendance->update([
                'check_in_time' => $checkInTime,
                'check_out_time' => $checkOutTime,
                'status' => $status,
                'is_approved' => true,
                'note' => 'Diperbarui melalui presensi kelas pada ' . now()->format('d/m/Y H:i'),
            ]);

            Notification::make()
                ->title('Presensi diperbarui!')
                ->body($studentHistory->student->name . ' - Status: ' . $this->getStatusLabel($status))
                ->success()
                ->send();
        } else {
            // Create new attendance
            Attendance::create([
                'student_history_id' => $studentHistory->id,
                'check_in_time' => $checkInTime,
                'check_out_time' => $checkOutTime,
                'status' => $status,
                'is_approved' => true,
                'note' => 'Dibuat melalui presensi kelas pada ' . now()->format('d/m/Y H:i'),
            ]);

            Notification::make()
                ->title('Presensi dibuat!')
                ->body($studentHistory->student->name . ' - Status: ' . $this->getStatusLabel($status))
                ->success()
                ->send();
        }

        // Refresh table to show updated status
        $this->resetTable();
    }

    private function bulkUpdateAttendance(Collection $records, string $status): void
    {
        if (!$this->selectedDate) {
            Notification::make()
                ->title('Tanggal tidak valid!')
                ->danger()
                ->send();
            return;
        }

        $updatedCount = 0;
        $createdCount = 0;

        foreach ($records as $studentHistory) {
            $existingAttendance = $this->getExistingAttendance($studentHistory);
            
            if ($existingAttendance) {
                $this->updateExistingAttendance($existingAttendance, $status);
                $updatedCount++;
            } else {
                $this->createNewAttendance($studentHistory, $status);
                $createdCount++;
            }
        }

        $message = '';
        if ($createdCount > 0) {
            $message .= "Dibuat: {$createdCount} presensi";
        }
        if ($updatedCount > 0) {
            if ($createdCount > 0) $message .= ', ';
            $message .= "Diperbarui: {$updatedCount} presensi";
        }

        Notification::make()
            ->title('Bulk update berhasil!')
            ->body($message . " dengan status: " . $this->getStatusLabel($status))
            ->success()
            ->send();

        $this->resetTable();
    }

    private function bulkDeleteAttendance(Collection $records): void
    {
        if (!$this->selectedDate) return;

        $deletedCount = 0;
        
        foreach ($records as $studentHistory) {
            $existingAttendance = $this->getExistingAttendance($studentHistory);
            if ($existingAttendance) {
                $existingAttendance->delete();
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            Notification::make()
                ->title('Presensi dihapus!')
                ->body("{$deletedCount} presensi berhasil dihapus.")
                ->success()
                ->send();

            $this->resetTable();
        } else {
            Notification::make()
                ->title('Tidak ada presensi!')
                ->body('Tidak ada presensi yang dapat dihapus untuk siswa yang dipilih.')
                ->warning()
                ->send();
        }
    }

    private function updateExistingAttendance($attendance, string $status): void
    {
        $attendanceDate = Carbon::parse($this->selectedDate);
        $schedule = $this->getScheduleForDate($attendanceDate);
        [$checkInTime, $checkOutTime] = $this->generateAttendanceTimes($attendanceDate, $status, $schedule);

        $attendance->update([
            'check_in_time' => $checkInTime,
            'check_out_time' => $checkOutTime,
            'status' => $status,
            'note' => 'Diperbarui melalui presensi kelas pada ' . now()->format('d/m/Y H:i'),
        ]);
    }

    private function createNewAttendance($studentHistory, string $status): void
    {
        $attendanceDate = Carbon::parse($this->selectedDate);
        $schedule = $this->getScheduleForDate($attendanceDate);
        [$checkInTime, $checkOutTime] = $this->generateAttendanceTimes($attendanceDate, $status, $schedule);

        Attendance::create([
            'student_history_id' => $studentHistory->id,
            'check_in_time' => $checkInTime,
            'check_out_time' => $checkOutTime,
            'status' => $status,
            'is_approved' => true,
            'note' => 'Dibuat melalui presensi kelas pada ' . now()->format('d/m/Y H:i'),
        ]);
    }

    // private function generateAttendanceTimes(Carbon $date, string $status, ?object $schedule): array
    // {
    //     $checkInTime = $date->copy();
    //     $checkOutTime = null;

    //     switch ($status) {
    //         case 'present':
    //             $checkInTime->setTime(7, 0); // Default 07:00
    //             $checkOutTime = $date->copy()->setTime(15, 0); // Default 15:00
    //             break;

    //         case 'late':
    //             // Use schedule late time or default
    //             $lateTime = $schedule ? Carbon::parse($schedule->check_in_end)->addMinutes(15) : $date->copy()->setTime(7, 45);
    //             $checkInTime = $date->copy()->setTime($lateTime->hour, $lateTime->minute);
    //             $checkOutTime = $date->copy()->setTime(15, 0);
    //             break;

    //         case 'missing':
    //             $checkInTime->setTime(7, 0); // Masuk normal tapi tidak pulang
    //             $checkOutTime = null;
    //             break;
    //     }

    //     return [$checkInTime, $checkOutTime];
    // }

    private function generateAttendanceTimes(Carbon $date, string $status, ?object $schedule): array
    {
        $checkInTime = $date->copy();
        $checkOutTime = null;

        if ($schedule) {
            // Parse waktu dari schedule yang sudah ada
            $checkInStart = Carbon::createFromTimeString($schedule->check_in_start);
            $checkInEnd = Carbon::createFromTimeString($schedule->check_in_end);
            $checkOutStart = Carbon::createFromTimeString($schedule->check_out_start);
            
            switch ($status) {
                case 'present':
                    // Masuk di awal waktu yang diizinkan
                    $checkInTime->setTime($checkInStart->hour, $checkInStart->minute);
                    $checkOutTime = $date->copy()->setTime($checkOutStart->hour, $checkOutStart->minute);
                    break;

                case 'late':
                    // Masuk 10-15 menit setelah batas waktu masuk
                    $lateTime = $checkInEnd->addMinutes(rand(10, 15));
                    $checkInTime->setTime($lateTime->hour, $lateTime->minute);
                    $checkOutTime = $date->copy()->setTime($checkOutStart->hour, $checkOutStart->minute);
                    break;

                case 'missing':
                    // Masuk normal tapi tidak pulang
                    $checkInTime->setTime($checkInStart->hour, $checkInStart->minute);
                    $checkOutTime = null;
                    break;
            }
        } else {
            // Fallback jika tidak ada schedule
            switch ($status) {
                case 'present':
                    $checkInTime->setTime(7, 0);
                    $checkOutTime = $date->copy()->setTime(15, 0);
                    break;
                case 'late':
                    $checkInTime->setTime(7, 45);
                    $checkOutTime = $date->copy()->setTime(15, 0);
                    break;
                case 'missing':
                    $checkInTime->setTime(7, 0);
                    $checkOutTime = null;
                    break;
            }
        }

        return [$checkInTime, $checkOutTime];
    }

    private function getScheduleForDate(Carbon $date): ?object
    {
        // Check override first
        $override = AttendanceScheduleOverride::whereDate('date', $date->toDateString())->first();
        if ($override) return $override;

        // Fallback to normal schedule
        $dayName = strtolower($date->format('l'));
        return AttendanceSchedule::where('day', $dayName)->first();
    }

    private function getStatusLabel(string $status): string
    {
        return match($status) {
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'missing' => 'Tidak Presensi Pulang',
            default => ucfirst($status)
        };
    }

    public function checkExistingAttendance(): void
    {
        $data = $this->form->getState();
        
        if (!$data['group_id'] || !$data['attendance_date']) {
            return;
        }

        $this->selectedGroupId = $data['group_id'];
        $this->selectedAcademicYearId = $data['academic_year_id'];
        $this->selectedDate = $data['attendance_date'];

        $existingCount = Attendance::whereHas('student_histories', function ($query) use ($data) {
            $query->where('group_id', $data['group_id'])
                  ->where('academic_year_id', $data['academic_year_id']);
        })
        ->whereDate('check_in_time', $data['attendance_date'])
        ->count();

        if ($existingCount > 0) {
            Notification::make()
                ->title('Informasi!')
                ->body("Sudah ada {$existingCount} presensi untuk kelas ini pada tanggal yang dipilih.")
                ->info()
                ->send();
        }

        $this->resetTable();
    }
}