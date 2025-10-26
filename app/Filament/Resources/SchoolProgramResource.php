<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\SchoolProgram;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SchoolProgramResource\Pages;
use App\Filament\Resources\SchoolProgramResource\RelationManagers;

class SchoolProgramResource extends Resource
{
    protected static ?string $model = SchoolProgram::class;

    protected static ?string $modelLabel = 'Program Sekolah';
    protected static ?string $pluralModelLabel = 'Program Sekolah';

    protected static ?string $navigationGroup = 'Program Sekolah';
    protected static ?string $navigationIcon = 'fas-microchip';

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
                                    ->hint('Foto Rasio Aspek 4:3 | Landscape')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('4:3')
                                    ->imageResizeTargetWidth('512')
                                    ->imageResizeTargetHeight('384')
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
                    ]),
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
            'index' => Pages\ListSchoolPrograms::route('/'),
            'create' => Pages\CreateSchoolProgram::route('/create'),
            'edit' => Pages\EditSchoolProgram::route('/{record}/edit'),
        ];
    }
}
