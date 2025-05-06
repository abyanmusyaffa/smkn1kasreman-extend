<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Group;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\GroupResource\Pages;
use Filament\Tables\Grouping\Group as GroupFil;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $modelLabel = 'Kelas';
    protected static ?string $pluralModelLabel = 'Kelas';

    protected static ?string $navigationGroup = 'Data Siswa';
    protected static ?string $navigationIcon = 'fas-building';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Kelas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('major_id')
                    ->label('Jurusan')
                    ->required()
                    ->native(false)
                    ->relationship(name: 'majors', titleAttribute: 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                GroupFil::make('majors.alias')
                    ->label('Jurusan'),
                ])
            ->defaultGroup(
                'majors.alias')
            ->groupingSettingsHidden()
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('majors.alias')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
