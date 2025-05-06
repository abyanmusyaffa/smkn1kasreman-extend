<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScoreCategoryResource\Pages;
use App\Filament\Resources\ScoreCategoryResource\RelationManagers;
use App\Models\ScoreCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScoreCategoryResource extends Resource
{
    protected static ?string $model = ScoreCategory::class;
    protected static ?string $modelLabel = 'Kategori Nilai';
    protected static ?string $pluralModelLabel = 'Kategori Nilai';

    protected static ?string $navigationGroup = 'Data Siswa';
    protected static ?string $navigationIcon = 'fas-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
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
            'index' => Pages\ListScoreCategories::route('/'),
            'create' => Pages\CreateScoreCategory::route('/create'),
            'edit' => Pages\EditScoreCategory::route('/{record}/edit'),
        ];
    }
}
