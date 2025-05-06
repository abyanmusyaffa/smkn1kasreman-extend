<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Major;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MajorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MajorResource\RelationManagers;

class MajorResource extends Resource
{
    protected static ?string $model = Major::class;
    protected static ?string $modelLabel = 'Konsentrasi Keahlian';
    protected static ?string $pluralModelLabel = 'Konsentrasi Keahlian';

    protected static ?string $navigationGroup = 'Sekolah';
    protected static ?string $navigationIcon = 'fas-graduation-cap';

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
                    Forms\Components\FileUpload::make('logo')
                        ->directory('/majors/logo')
                        ->image()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Foto Sampul')
                        ->multiple()
                        ->minFiles(2)
                        ->maxFiles(2)
                        ->directory('/majors/cover')
                        ->image()
                        ->panelLayout('grid')
                        ->reorderable()
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
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
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
                        ->fileAttachmentsDirectory('/attachments-major')
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
