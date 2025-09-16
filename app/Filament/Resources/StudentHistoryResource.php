<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use App\Models\StudentHistory;
use PhpParser\Node\Stmt\Label;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use App\Models\Group as ModelsGroup;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentHistoryResource\Pages;
use App\Filament\Resources\StudentHistoryResource\RelationManagers;

class StudentHistoryResource extends Resource
{
    protected static ?string $model = StudentHistory::class;

    protected static ?string $modelLabel = 'Riwayat Siswa';
    protected static ?string $pluralModelLabel = 'Riwayat Siswa';

    protected static ?string $navigationGroup = 'Siswa';
    protected static ?string $navigationIcon = 'fas-arrow-up-wide-short';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\Select::make('student_id')
                        ->label('Siswa')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->relationship(name: 'students', titleAttribute: 'name')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Select::make('group_id')
                        ->label('Kelas')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->relationship(name: 'groups', titleAttribute: 'name')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\Select::make('academic_year_id')
                        ->label('Tahun Ajar')
                        ->required()
                        ->native(false)
                        // ->searchable()
                        ->relationship(
                            name: 'academic_years',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query) => $query->select('id', 'name', 'semester')
                        )
                        ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - Semester {$record->semester}")
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\TextInput::make('number_in_group')
                        ->label('Nomor Presensi')
                        ->maxLength(255)
                        ->numeric()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 2,
                        ]),
                    Forms\Components\Select::make('status')
                        ->required()
                        ->native(false)
                        ->options([
                            'active' => 'Aktif',
                            'passed' => 'Selesai',
                            'graduated' => 'Lulus',
                            'transferred' => 'Pindah',
                            'dropped' => 'Keluar'
                        ])
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\Textarea::make('information')
                        ->label('Keterangan')
                        ->rows(2)
                        ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'passed' => 'Selesai',
                        'graduated' => 'Lulus',
                        'transferred' => 'Pindah',
                        'dropped' => 'Keluar'
                    ])
                    ->default('active'),
                SelectFilter::make('group')
                    ->label('Kelas')
                    ->relationship('groups', 'name'),
                SelectFilter::make('academic_year')
                    ->label('Tahun Ajar')
                    ->relationship(
                        name: 'academic_years',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->select('id', 'name', 'semester')
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - Semester {$record->semester}"),
            ])
            ->groups([
                Group::make('academic_years.name')
                    ->label('Tahun Ajar'),
                Group::make('groups.name')
                    ->label('Kelas'),
            ])
            ->defaultGroup('groups.name')
            ->columns([
                Tables\Columns\TextInputColumn::make('number_in_group')
                    ->sortable()
                    ->label('Nomor Presensi'),
                Tables\Columns\TextColumn::make('students.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.students.edit', ['record' => $record->students->id]))
                    ->openUrlInNewTab(false),
                Tables\Columns\TextColumn::make('groups.name')
                    ->label('Kelas')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('academic_years.name')
                    ->label('Tahun Ajar')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('academic_years.semester')
                    ->label('Semester')
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'info',
                        '2' => 'success',
                    })
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            '1' => '1 (Ganjil)',
                            '2' => '2 (Genap)',
                            default => ucfirst($state),
                        };
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'info',
                        'passed' => 'success',
                        'graduated' => 'success',
                        'transferred' => 'warning',
                        'dropped' => 'danger',
                    })
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'active' => 'Aktif',
                            'passed' => 'Selesai',
                            'graduated' => 'Lulus',
                            'transferred' => 'Pindah',
                            'dropped' => 'Keluar',
                            default => ucfirst($state),
                        };
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('generate_new_student_histories')
                        ->label('Naik Kelas / Semester Berikutnya')
                        ->icon('fas-circle-arrow-up')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('academic_year_id')
                                ->label('Tahun Ajar Baru')
                                ->options(
                                    AcademicYear::all()
                                        ->mapWithKeys(fn ($year) => [
                                            $year->id => "{$year->name} - Semester {$year->semester}",
                                        ])
                                )
                                ->default(
                                    fn () => AcademicYear::query()
                                        ->where('is_active', true)
                                        ->first()?->id
                                )
                                ->searchable()
                                ->required(),

                            Forms\Components\Select::make('group_id')
                                ->label('Kelas Baru')
                                ->options(ModelsGroup::all()->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'passed',
                                ]);
        
                                StudentHistory::create([
                                    'student_id' => $record->student_id,
                                    'academic_year_id' => $data['academic_year_id'],
                                    'group_id' => $data['group_id'],
                                    'status' => 'active',
                                ]);

                            }
                            Notification::make()
                                ->title('Data berhasil ditambahkan ke Kelas')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                    BulkAction::make('update_status')
                        ->label('Ubah Status')
                        ->icon('fas-user-check')
                        ->color('info')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Status Baru')
                                ->options([
                                    'active' => 'Aktif',
                                    'passed' => 'Selesai',
                                    'graduated' => 'Lulus',
                                    'transferred' => 'Pindah',
                                    'dropped' => 'Keluar',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => $data['status'],
                                ]);

                            }
                            Notification::make()
                                ->title('Status berhasil diubah')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentHistories::route('/'),
            'create' => Pages\CreateStudentHistory::route('/create'),
            'edit' => Pages\EditStudentHistory::route('/{record}/edit'),
        ];
    }
}
