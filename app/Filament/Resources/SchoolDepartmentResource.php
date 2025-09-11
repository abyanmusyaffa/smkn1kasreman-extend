<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\SchoolDepartment;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SchoolDepartmentResource\Pages;
use App\Filament\Resources\SchoolDepartmentResource\RelationManagers;

class SchoolDepartmentResource extends Resource
{
    protected static ?string $model = SchoolDepartment::class;

    protected static ?string $modelLabel = 'Departemen';
    protected static ?string $pluralModelLabel = 'Departemen';

    // protected static ?string $navigationGroup = 'Kesiswaan';
    protected static ?string $navigationIcon = 'fas-building';

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
                    Forms\Components\Repeater::make('contacts')
                        ->label('Kontak')
                        ->addActionLabel('Tambahkan Kontak')
                        ->schema([
                            Forms\Components\Select::make('platform')
                                ->options([
                                    'whatsapp' => 'Whatsapp',
                                    'email' => 'Email',
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
                    
                            return 'school-departments/' . ($slug ?: 'temp') . '/attachments';
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
                    Forms\Components\Repeater::make('galleries')
                        ->label('Galeri')
                        ->addActionLabel('Tambahkan Galeri')
                        // ->minItems(2)
                        ->schema([
                            Forms\Components\TextInput::make('caption')
                                ->label('Keterangan')
                                ->required()
                                ->live()
                                ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter') 
                                ->maxLength(42)
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 12,
                                ]),
                            Forms\Components\FileUpload::make('photo')
                                ->label('Foto')
                                ->image()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('4:3')
                                ->imageResizeTargetWidth('1024')
                                ->imageResizeTargetHeight('768')
                                ->hint('Foto Rasio Aspek 4:3 | Landscape')
                                ->directory(function ($get) {
                                    return 'school-departments/' . ($get('../../slug') ?: 'temp') . '/galleries';
                                })
                                ->required()
                                ->columnSpan([
                                    'default' => 2,
                                    'lg' => 12,
                                ]),
                        ])
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
                                ->hint('Foto Rasio Aspek 4:6 | Potrait')
                                ->image()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('4:6')
                                ->imageResizeTargetWidth('560')
                                ->imageResizeTargetHeight('840')
                                ->directory(function ($get) {
                                    return 'school-departments/' . ($get('../../slug') ?: 'temp') . '/staff';
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
            'index' => Pages\ListSchoolDepartments::route('/'),
            'create' => Pages\CreateSchoolDepartment::route('/create'),
            'edit' => Pages\EditSchoolDepartment::route('/{record}/edit'),
        ];
    }
}
