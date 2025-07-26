<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Extracurricular;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ExtracurricularResource\Pages;
use App\Filament\Resources\ExtracurricularResource\RelationManagers;

class ExtracurricularResource extends Resource
{
    protected static ?string $model = Extracurricular::class;
    protected static ?string $modelLabel = 'Ekstrakurikuler';
    protected static ?string $pluralModelLabel = 'Ekstrakurikuler';

    protected static ?string $navigationGroup = 'Kesiswaan';
    protected static ?string $navigationIcon = 'fas-baseball-ball';

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
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->hint(fn ($component) => 'Maksimal ' . $component->getMaxLength() . ' Karakter')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                        ->maxLength(40)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Hidden::make('slug'),
                    Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->maxSize(512)
                        ->directory(function ($get) {
                            $slug = $get('slug');
                    
                            return 'extracurriculars/' . ($slug ?: 'temp');
                        })
                        ->default('/default/logo.svg')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
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
                    ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\RichEditor::make('description')
                        ->label('Deskripsi')
                        ->fileAttachmentsDirectory(function ($get) {
                            $slug = $get('slug');
                    
                            return 'extracurriculars/' . ($slug ?: 'temp') . '/attachments';
                        })
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'h4',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('galleries')
                        ->label('Galeri')
                        ->hint(fn ($component) => 'Minimal ' . $component->getMinFiles() . ' Foto Rasio Aspek 4:3')
                        ->directory(function ($get) {
                            $slug = $get('slug');
                    
                            return 'extracurriculars/' . ($slug ?: 'temp') . '/galleries';
                        })
                        ->required()
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('4:3')
                        ->imageResizeTargetWidth('1024')
                        ->imageResizeTargetHeight('768')
                        ->multiple()
                        ->minFiles(2)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Repeater::make('staff')
                        ->label('Pengurus')
                        ->addActionLabel('Tambahkan Pengurus')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama')
                                ->required()
                                ->live()
                                ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter') 
                                ->maxLength(42)
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 8,
                                ]),
                            Forms\Components\TextInput::make('role')
                                ->label('Jabatan')
                                ->required()
                                ->live()
                                ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter')
                                ->maxLength(24)
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 4,
                                ]),
                            Forms\Components\FileUpload::make('photo')
                                ->label('Foto')
                                ->image()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('4:6')
                                ->imageResizeTargetWidth('560')
                                ->imageResizeTargetHeight('840')
                                ->directory(function ($get) {
                                    return 'extracurriculars/' . ($get('../../slug') ?: 'temp') . '/staff';
                                })
                                ->required()
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 12,
                                ]),
                        ])
                        ->columns([
                            'default' => 2,
                            'lg' => 12,
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListExtracurriculars::route('/'),
            'create' => Pages\CreateExtracurricular::route('/create'),
            'edit' => Pages\EditExtracurricular::route('/{record}/edit'),
        ];
    }
}
