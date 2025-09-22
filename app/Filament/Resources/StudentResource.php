<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use App\Models\Group as ModelsGroup;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $modelLabel = 'Data Pokok Siswa';
    protected static ?string $pluralModelLabel = 'Data Pokok Siswa';

    protected static ?string $navigationGroup = 'Siswa';
    protected static ?string $navigationIcon = 'fas-user-graduate';

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
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Foto')
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('3:4')
                        ->imageResizeTargetWidth('600')
                        ->imageResizeTargetHeight('800')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('phone')
                        ->label('Nomor WA Aktif')
                        ->tel()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('email')
                        ->label('Email Aktif')
                        ->email()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('username')
                        ->unique(ignoreRecord: true )
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                            $component->state('');
                        })
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->required(fn (string $operation): bool => $operation == 'create')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('card_uid')
                        ->label('UID Kartu Pelajar')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\TextInput::make('nis')
                        ->label('NIS (Nomor Induk Siswa)')
                        ->required()
                        ->unique(ignoreRecord: true )
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('nisn')
                        ->label('NISN (Nomor Induk Siswa Nasional)')
                        ->required()
                        ->unique(ignoreRecord: true )
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('nik')
                        ->label('NIK (Nomor Induk Kependudukan')
                        ->unique(ignoreRecord: true )
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('nokk')
                        ->label('Nomor Kartu Keluarga')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\TextInput::make('previous_school')
                        ->label('Sekolah Asal')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 9,
                        ]),
                    Forms\Components\Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->required()
                        ->options([
                            'male' => 'Laki-laki',
                            'female' => 'Perempuan'
                        ])
                        ->native(false)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\TextInput::make('birth_place')
                        ->label('Tempat Lahir')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('Tanggal Lahir')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\Select::make('religion')
                        ->label('Agama')
                        ->options([
                            'islam' => 'Islam',
                            'kristen' => 'Kristen',
                            'hindu' => 'Hindu',
                            'budha' => 'Budha',
                            'konghucu' => 'Konghucu',
                            'another' => 'Lainnya',
                        ])
                        ->native(false)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat')
                        ->placeholder('Jalan Nakula No.21 Dusun Sukajaya RT002 RW003')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('address_village')
                        ->label('Kelurahan/Desa')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('address_subdistrict')
                        ->label('Kecamatan')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('address_regency')
                        ->label('Kabupaten/Kota')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('address_province')
                        ->label('Provinsi')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\TextInput::make('father_name')
                        ->label('Nama Ayah')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('father_phone')
                        ->label('Nomor WA Aktif Ayah')
                        ->tel()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('father_job')
                        ->label('Pekerjaan Ayah')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),                    
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\TextInput::make('mother_name')
                        ->label('Nama Ibu')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('mother_phone')
                        ->label('Nomor WA Aktif Ibu')
                        ->tel()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('mother_job')
                        ->label('Pekerjaan Ibu')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\TextInput::make('guardian_name')
                        ->label('Nama Wali')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('guardian_phone')
                        ->label('Nomor WA Aktif Wali')
                        ->tel()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('guardian_job')
                        ->label('Pekerjaan Wali')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->filters([
                SelectFilter::make('student_histories_status')
                    ->label('Status Kelas')
                    ->options([
                        'not_student_histories' => 'Belum punya Kelas',
                        'has_student_histories' => 'Sudah punya kelas',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['value'] === 'not_student_histories',
                                fn (Builder $query): Builder => $query->doesntHave('student_histories'),
                            )
                            ->when(
                                $data['value'] === 'has_student_histories',
                                fn (Builder $query): Builder => $query->has('student_histories'),
                            );
                    }),
                SelectFilter::make('status')
                    // ->label('Status')
                    ->options([
                        'active' => 'Aktif',
                        'passed' => 'Selesai',
                        'graduated' => 'Lulus',
                        'transferred' => 'Pindah',
                        'dropped' => 'Keluar',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
    
                        return $query->whereHas('student_histories', function (Builder $q) use ($data) {
                            $q->where('status', $data['value'])
                              ->latest();
                        });
                    }),
                          
                // SelectFilter::make('group')
                //     ->label('Kelas')
                //     ->relationship(
                //         name: 'student_histories.groups',
                //         titleAttribute: 'name'
                //     ),
            ])
            // ->groups([
            //     Group::make('student_histories.groups')
            //         ->label('Kelas'),
            //     Group::make('groups.majors.alias')
            //         ->label('Jurusan'),
            //     Group::make('student_histories.academic_years')
            //         ->label('Tahun Ajar'),
            //     Group::make('status')
            //         ->label('Status'),
            // ])
            // ->defaultGroup('groups.name')
            ->columns([
                Tables\Columns\TextColumn::make('card_uid')
                    ->label('UID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),   
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Nama')
                    ->searchable(), 
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),   
                Tables\Columns\TextColumn::make('address')
                    ->wrap()
                    ->label('Alamat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),   
                Tables\Columns\TextColumn::make('address_village')
                    ->label('Kelurahan/Desa')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),   
                Tables\Columns\TextColumn::make('address_subdistrict')
                    ->label('Kecamatan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),   
                Tables\Columns\TextColumn::make('address_regency')
                    ->label('Kabupaten')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),     
                Tables\Columns\TextColumn::make('address_province')
                    ->label('Provinsi')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),     
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'male' => 'L',
                            'female' => 'P',
                            default => ucfirst($state),
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'warning',
                        'female' => 'info',
                    })
                    ->toggleable(isToggledHiddenByDefault: true), 
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()    
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()    
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('generate_student_histories')
                        ->label('Masukkan ke Kelas')
                        ->icon('fas-arrow-right-to-city')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('academic_year_id')
                                ->label('Tahun Ajar & Semester')
                                // ->options(
                                //     AcademicYear::query()
                                //         ->where('is_active', true)
                                //         ->get()
                                //         ->mapWithKeys(fn ($year) => [
                                //             $year->id => "{$year->name} - Semester {$year->semester}",
                                //         ])
                                // )
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
                                ->label('Kelas')
                                ->options(
                                    ModelsGroup::all()->pluck('name', 'id')
                                )
                                ->searchable()
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $student) {
                                $exists = $student->student_histories()
                                    ->where('academic_year_id', $data['academic_year_id'])
                                    ->where('group_id', $data['group_id'])
                                    ->exists();

                                if (! $exists) {
                                    $student->student_histories()->create([
                                        'academic_year_id' => $data['academic_year_id'],
                                        'group_id'         => $data['group_id'],
                                        'status'           => 'active',
                                    ]);
                                }
                            }
                            Notification::make()
                                ->title('Data berhasil ditambahkan ke Kelas')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
