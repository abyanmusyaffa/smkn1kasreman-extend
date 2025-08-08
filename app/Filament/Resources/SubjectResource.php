<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Major;
use App\Models\Subject;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ScoreCategory;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\SubjectResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubjectResource\RelationManagers;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;
    protected static ?string $modelLabel = 'Mata Pelajaran';
    protected static ?string $pluralModelLabel = 'Mata Pelajaran';

    protected static ?string $navigationGroup = 'Jadwal Pelajaran';
    protected static ?string $navigationIcon = 'fas-book-open';

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
                    Forms\Components\Select::make('score_category_id')
                        ->label('Kategori')
                        ->native(false)
                        ->relationship(name: 'score_categories', titleAttribute: 'name')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\Select::make('major_id')
                        ->label('Program Keahlian')
                        ->native(false)
                        ->relationship(name: 'majors', titleAttribute: 'expertise_concentration')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Mata Pelajaran')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 8,
                        ]),
                    Forms\Components\TextInput::make('code')
                        ->label('Kode')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('score_categories.name')
                    ->label('Kategori'),
                Group::make('majors.alias')
                    ->label('Jurusan'),
            ])
            ->defaultGroup('score_categories.name')
            ->columns([
                // Tables\Columns\TextColumn::make('score_categories.name')
                //     ->label('Kategori')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    // ->rules(['required', 'max:255'])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('majors.alias')
                    ->label('Jurusan')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'TKJ' => 'danger',
                        'AKL' => 'warning',
                        'KL' => 'success',
                        'DPB' => 'info',
                    })
                    ->numeric()
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
