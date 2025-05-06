<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Alumni;
use App\Models\Subject;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\Group as GroupModel;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Imports\AlumniImporter;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\AlumniResource\Pages;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;
    protected static ?string $modelLabel = 'Siswa';
    protected static ?string $pluralModelLabel = 'Siswa';

    protected static ?string $navigationGroup = 'Data Siswa';
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
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    // Forms\Components\Placeholder::make('photo_preview')
                    //     ->label('Foto')
                    //     ->content(function ($record) {
                    //         // Ambil URL dari project lain
                    //         $url = 'http://dev-tracer-smkn1kasreman.test/storage/' . $record->photo;
                    //         return '<img src="' . $url . '" style="width: 150px; height: auto;" />';
                    //     })
                    //     ->extraAttributes(['class' => 'pt-2'])
                    //     ->html(),
                    Forms\Components\TextInput::make('name')
                        ->label('Name')
                        ->required()
                        // ->live()
                        // ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter')
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
                    Forms\Components\TextInput::make('phone')
                        ->label('Nomor Telepon')
                        ->tel()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('birth_place')
                        ->label('Tempat Lahir')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('Tanggal Lahir')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('father')
                        ->label('Nama Bapak')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('mother')
                        ->label('Nama Ibu')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
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
                    Forms\Components\TextInput::make('nis')
                        ->label('Nomer Induk Siswa')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\TextInput::make('nisn')
                        ->label('Nomer Induk Siswa Nasional')
                        ->required()
                        ->numeric()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\Select::make('group_id')
                        ->label('Kelas')
                        ->native(false)
                        ->searchable()
                        ->relationship(name: 'groups', titleAttribute: 'name')
                        ->live()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\TextInput::make('enrollment_year')
                        ->label('Tahun Masuk')
                        ->required()
                        ->numeric()
                        ->maxLength(4)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\TextInput::make('passing_year')
                        ->label('Tahun Keluar')
                        ->numeric()
                        ->maxLength(4)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\TextInput::make('academic_year')
                        ->label('Tahun Ajaran')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->required()
                        ->options([
                            'active' => 'Aktif',
                            'passing' => 'Lulus',
                            'transferred' => 'Pindah',
                            'dropped' => 'Keluar'
                        ])
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, ?string $state) {
                            if (in_array($state, ['passing', 'transferred', 'dropped'])) {
                                $set('passing_year', now()->year);
                            } elseif ($state === 'active') {
                                $set('passing_year', null);
                            }
                        })
                        ->native(false)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\FileUpload::make('photo')
                        ->image()
                        ->label('Foto')
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('3:4')
                        ->imageResizeTargetWidth('600')
                        ->imageResizeTargetHeight('800')
                        ->directory(fn ($record) => 'alumnis/' . Str::slug($record?->groups?->name ?? 'unknown'))
                        ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                            $nis = $record?->nis ?? '0000';
                            $prefix = substr($nis, 0, 4);
                        
                            return $prefix . '.' . $file->getClientOriginalExtension();
                        })
                        ->default('/default/alumni.svg')
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
                    Repeater::make('scores')
                    ->relationship('scores') 
                    ->schema([
                        Select::make('subject_id')
                            ->label('Mata Pelajaran')
                            ->reactive()
                            // ->relationship('subjects', 'name')
                            ->options(function ($get) {
                                $groupId = $get('../../group_id'); // ambil group_id yang dipilih
                
                                $majorId = GroupModel::find($groupId)?->major_id;
                
                                return Subject::query()
                                    ->where(function ($query) use ($majorId) {
                                        $query->whereNull('major_id');
                                        if ($majorId) {
                                            $query->orWhere('major_id', $majorId);
                                        }
                                    })
                                    ->pluck('name', 'id');
                            })
                            ->searchable(),
                        TextInput::make('score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->label('Nilai')
                            ->required(),
                    ])
                    ->columns(2)
                    ->label('Data Nilai')
                    ->defaultItems(0)
                    ->collapsible()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 12,
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('groups.name')
                    ->label('Kelas'),
                Group::make('groups.majors.alias')
                    ->label('Jurusan'),
                Group::make('academic_year')
                    ->label('Tahun Ajar'),
                Group::make('status')
                    ->label('Status'),
            ])
            ->defaultGroup('groups.name')
            // ->modifyQueryUsing(function (Builder $query) {
            //     return $query->selectRaw('
            //         *,
            //         CASE status
            //             WHEN "active" THEN "Aktif"
            //             WHEN "passing" THEN "Lulus"
            //             WHEN "transferred" THEN "Pindah"
            //             WHEN "dropped" THEN "Keluar"
            //             ELSE status
            //         END AS status_label
            //     ');
            // })
            // ->headerActions([
            //     ImportAction::make()
            //         ->importer(AlumniImporter::class)
            // ])
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->label('Status')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'active' => 'Aktif',
                            'passing' => 'Lulus',
                            'transferred' => 'Pindah',
                            'dropped' => 'Keluar',
                            default => ucfirst($state),
                        };
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'info',
                        'passing' => 'success',
                        'transferred' => 'warning',
                        'dropped' => 'danger',
                    })
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('groups.name')
                    ->searchable()
                    ->label('Kelas')
                    // ->badge()
                    // ->color(fn (string $state): string => match ($state) {
                    //     'TKJ' => 'danger',
                    //     'AKL' => 'warning',
                    //     'KL' => 'success',
                    //     'DPB' => 'info',
                    // })
                    ->sortable(),
                Tables\Columns\TextColumn::make('groups.majors.alias')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'TKJ' => 'danger',
                        'AKL' => 'warning',
                        'KL' => 'success',
                        'DPB' => 'info',
                    })
                    ->label('Jurusan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('enrollment_year')
                    ->sortable()
                    ->label('Tahun Masuk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('passing_year')
                    ->sortable()
                    ->label('Tahun Keluar')
                    ->searchable(),
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
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    // Action::make('lihat_nilai')
                    //     ->label('Nilai')
                    //     ->icon('fas-clipboard-list')
                    //     ->url(fn ($record) => AlumniResource::getUrl('score', ['record' => $record->id])),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->size(ActionSize::Large)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('updatePassing')
                        ->label('Ubah Status Lulus')
                        ->icon('fas-graduation-cap')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'passing',
                                    'passing_year' => Carbon::now()->year
                                ]);
                            }
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('updateActive')
                        ->label('Ubah Status Aktif')
                        ->icon('heroicon-s-check-badge')
                        ->color('info')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'active',
                                    'passing_year' => ''
                                ]);
                            }
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListAlumnis::route('/'),
            'create' => Pages\CreateAlumni::route('/create'),
            'edit' => Pages\EditAlumni::route('/{record}/edit'),
        ];
    }
}
