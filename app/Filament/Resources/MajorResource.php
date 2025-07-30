<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Major;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MajorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MajorResource\RelationManagers;

class MajorResource extends Resource
{
    protected static ?string $model = Major::class;
    protected static ?string $modelLabel = 'Program Keahlian';
    protected static ?string $pluralModelLabel = 'Program Keahlian';

    protected static ?string $navigationGroup = 'Sekolah';
    protected static ?string $navigationIcon = 'fas-graduation-cap';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Jika user bukan admin, hanya tampilkan data miliknya
        if (!auth()->user()->hasRole(['admin', 'super_admin'])) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }
    
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
                    Forms\Components\Select::make('user_id')
                        ->label('Administrator')
                        ->searchable()
                        ->native(false)
                        ->relationship(name: 'users', titleAttribute: 'name')
                        ->disabled(function () {
                            return !auth()->user()->hasRole(['admin', 'super_admin']);
                        })    
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('expertise_program')
                        ->label('Program Keahlian')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('expertise_concentration')
                        ->label('Konsentrasi Keahlian')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 9,
                        ]),
                    Forms\Components\TextInput::make('alias')
                        ->required()
                        ->maxLength(5)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('alias', strtoupper($state)))
                        ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\Repeater::make('contacts')
                        ->label('Kontak/Media Sosial')
                        ->addActionLabel('Tambahkan Kontak/Media Sosial')
                        ->schema([
                            Forms\Components\Select::make('platform')
                                ->options([
                                    'whatsapp' => 'Whatsapp',
                                    'email' => 'Email',
                                    'instagram' => 'Instagram',
                                    'facebook' => 'Facebook',
                                    'tiktok' => 'Tiktok',
                                    'youtube' => 'Youtube',
                                ])
                                ->native(false)
                                ->required(),
                            Forms\Components\TextInput::make('url')
                                ->label('Tautan')
                                ->url()
                                ->required(),
                        ])
                        ->columns(2)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('logo')
                        // ->directory('/majors/logo')
                        ->directory(function ($get) {
                            $alias = $get('alias');
                    
                            return 'majors/' . (Str::slug($alias) ?: 'temp');
                        })
                        ->image()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('galleries')
                        ->label('Galeri')
                        ->multiple()
                        ->minFiles(2)
                        ->directory(function ($get) {
                            $alias = $get('alias');
                    
                            return 'majors/' . (Str::slug($alias) ?: 'temp') . '/galleries';
                        })
                        // ->directory('/majors/cover')
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('4:3')
                        ->imageResizeTargetWidth('1024')
                        ->imageResizeTargetHeight('768')
                        ->panelLayout('grid')
                        ->reorderable()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('study_group')
                        ->label('Jumlah Rombel')
                        ->suffix('Rombel')
                        ->required()
                        ->numeric()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\TextInput::make('study_period')
                        ->label('Masa Belajar')
                        ->suffix('Tahun')
                        ->required()
                        ->numeric()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\TextInput::make('total_students')
                        ->label('Jumlah Siswa')
                        ->suffix('Siswa')
                        ->required()
                        ->numeric()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\RichEditor::make('description')
                        ->label('Deskripsi')
                        ->fileAttachmentsDirectory(function ($get) {
                            $alias = $get('alias');
                    
                            return 'majors/' . (Str::slug($alias) ?: 'temp') . '/attachments';
                        })
                        ->required()
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
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
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label(''),
                Tables\Columns\TextColumn::make('alias')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'TKJ' => 'danger',
                        'AKL' => 'warning',
                        'KL' => 'success',
                        'DPB' => 'info',
                    })
                    ->label('')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expertise_concentration')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('study_group')
                    ->label('Jumlah Rombel')
                    ->suffix(' Rombel')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('study_period')
                    ->label('Masa Belajar')
                    ->suffix(' Tahun')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_students')
                    ->label('Jumlah Siswa')
                    ->suffix(' Siswa')
                    ->numeric()
                    ->sortable(),
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
            ->paginated(false)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListMajors::route('/'),
            'create' => Pages\CreateMajor::route('/create'),
            'edit' => Pages\EditMajor::route('/{record}/edit'),
        ];
    }
}
