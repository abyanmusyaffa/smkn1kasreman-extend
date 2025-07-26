<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\TeachingFactory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TeachingFactoryResource\Pages;
use App\Filament\Resources\TeachingFactoryResource\RelationManagers;

class TeachingFactoryResource extends Resource
{
    protected static ?string $model = TeachingFactory::class;

    protected static ?string $modelLabel = 'Teaching Factory';
    protected static ?string $pluralModelLabel = 'Teaching Factory';

    protected static ?string $navigationGroup = 'Program Sekolah';
    protected static ?string $navigationIcon = 'fas-industry';

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
                    
                            return 'teaching-factories/' . ($slug ?: 'temp');
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
                    
                            return 'teaching-factories/' . ($slug ?: 'temp') . '/attachments';
                        })
                        ->toolbarButtons([
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
                    
                            return 'teaching-factories/' . ($slug ?: 'temp') . '/galleries';
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
                ]),
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\Repeater::make('products')
                        ->label('Produk')
                        ->addActionLabel('Tambahkan Produk')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Produk')
                                ->required()
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 12,
                                ]),
                            Forms\Components\FileUpload::make('photo')
                                ->label('Foto Produk')
                                ->required()
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 12,
                                ]),
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
                    Forms\Components\Repeater::make('services')
                        ->label('Layanan')
                        ->addActionLabel('Tambahkan Layanan')
                        ->schema([
                            Forms\Components\TextInput::make('Nama Layanan')
                                ->label('Foto Produk')
                                ->required()
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 12,
                                ]),
                        ])
                        ->columns(2)
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
                    ->searchable()
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
            'index' => Pages\ListTeachingFactories::route('/'),
            'create' => Pages\CreateTeachingFactory::route('/create'),
            'edit' => Pages\EditTeachingFactory::route('/{record}/edit'),
        ];
    }
}
