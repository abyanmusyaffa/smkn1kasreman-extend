<?php

namespace App\Filament\Pages;

use App\Models\Group;
use App\Models\Student;
use Filament\Pages\Page;
use App\Models\Attendance;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use App\Models\StudentHistory;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class AttendancePage extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationGroup = 'Presensi';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $title = 'Manajemen Presensi';
    protected static string $view = 'filament.pages.attendance-page';

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
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('groups.name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('academic_years_display')
                    ->label('Tahun Ajar')
                    ->alignCenter()
                    ->getStateUsing(fn ($record) => $record->academic_years
                        ? $record->academic_years->name . ' - ' . ($record->academic_years->semester == '1' ? 'Ganjil' : 'Genap')
                        : '-'
                    )
                    ->badge()
                    ->color(fn ($record) => $record->academic_years?->semester == '1' ? 'info' : 'success')
                    ->sortable(),
                
                TextColumn::make('attendances_count')
                    ->label('Total Presensi')
                    ->alignCenter()
                    ->counts('attendances')
                    ->sortable(),
                
                TextColumn::make('present_count')
                    ->label('Hadir')
                    ->alignCenter()
                    ->getStateUsing(function ($record) {
                        return $record->attendances()
                            ->where('status', 'present')
                            ->count();
                    })
                    ->badge()
                    ->color('success'),
                
                TextColumn::make('late_count')
                    ->label('Terlambat')
                    ->alignCenter()
                    ->getStateUsing(function ($record) {
                        return $record->attendances()
                            ->where('status', 'late')
                            ->count();
                    })
                    ->badge()
                    ->color('warning'),
                
                TextColumn::make('missing_count')
                    ->label('Tidak Presensi Pulang')
                    ->alignCenter()
                    ->getStateUsing(function ($record) {
                        return $record->attendances()
                            ->where('status', 'missing')
                            ->count();
                    })
                    ->badge()
                    ->color('danger'),
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship(
                        name: 'academic_years',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->select('id', 'name', 'semester')->orderBy('name', 'desc')
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - " . ($record->semester == 1 ? 'Ganjil' : 'Genap'))
                    ->default(AcademicYear::where('is_active', true)->first()?->id),
                
                SelectFilter::make('group_id')
                    ->label('Kelas')
                    ->options(Group::pluck('name', 'id'))
                    ->searchable(),
                
                SelectFilter::make('status')
                    ->label('Status Siswa')
                    ->options([
                        'active' => 'Aktif',
                        'passed' => 'Selesai',
                        'graduated' => 'Wisuda',
                        'transferred' => 'Pindah',
                        'dropped' => 'Keluar',
                    ])
                    ->default('active'),
                
                // Filter::make('attendance_date')
                //     ->form([
                //         Grid::make(2)
                //             ->schema([
                //                 DatePicker::make('from_date')
                //                     ->label('Dari Tanggal'),
                //                 DatePicker::make('to_date')
                //                     ->label('Sampai Tanggal'),
                //             ])
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {
                //         return $query
                //             ->when(
                //                 $data['from_date'],
                //                 fn (Builder $query, $date): Builder => $query->whereHas('attendances', function ($q) use ($date) {
                //                     $q->whereDate('check_in_time', '>=', $date);
                //                 })
                //             )
                //             ->when(
                //                 $data['to_date'],
                //                 fn (Builder $query, $date): Builder => $query->whereHas('attendances', function ($q) use ($date) {
                //                     $q->whereDate('check_in_time', '<=', $date);
                //                 })
                //             );
                //     }),
            ])
            ->actions([
                Action::make('view_detail')
                    ->label('Lihat ')
                    ->icon('heroicon-m-eye')
                    ->url(fn (StudentHistory $record): string => route('filament.admin.pages.attendance-detail', ['student_history' => $record->id])),
                // ActionGroup::make([
                    
                //     Action::make('create_attendance')
                //         ->label('Buat Presensi')
                //         ->icon('heroicon-m-plus')
                //         ->color('success')
                //         ->url(fn (StudentHistory $record): string => route('filament.admin.pages.create-attendance', ['student_history' => $record->id])),
                // ])->size(ActionSize::Large)
            ])
            ->headerActions([
                Action::make('create_class_attendance')
                    ->label('Presensi per Kelas')
                    ->icon('heroicon-m-users')
                    ->color('primary')
                    ->url(route('filament.admin.pages.create-class-attendance')),
            ])
            ->paginated([12, 24, 36, 48])
            ->defaultPaginationPageOption(36);
    }

    protected function getTableQuery(): Builder
    {
        return StudentHistory::query()
            ->with(['students', 'groups', 'academic_years', 'attendances'])
            ->withCount('attendances')
            ->orderBy('student_id');
    }

    // public static function getRoutes(): array
    // {
    //     return [
    //         Route::get('/attendance', static::class)->name('attendance'),
    //         Route::get('/attendance/detail/{student_history}', AttendanceDetailPage::class)->name('attendance-detail'),
    //         // Route::get('/attendance/create/{student_history?}', CreateAttendancePage::class)->name('create-attendance'),
    //         // Route::get('/attendance/create-class', CreateClassAttendancePage::class)->name('create-class-attendance'),
    //         // Route::get('/attendance/create-manual', CreateManualAttendancePage::class)->name('create-manual-attendance'),
    //     ];
    // }
}