<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Facility;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FacilityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FacilityResource\RelationManagers;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;
    protected static ?string $modelLabel = 'Sarana Prasarana';
    protected static ?string $pluralModelLabel = 'Sarana Prasarana';

    protected static ?string $navigationGroup = 'Sarpras';
    protected static ?string $navigationIcon = 'fas-city';

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
                        ->label('Name')
                        ->required()
                        ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter')
                        ->maxLength(40)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Foto')
                        ->image()
                        ->required()
                        ->directory('/facilities')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->required()
                        ->options([
                            'infrastructure' => 'Sarana Infrastruktur',
                            'learning' => 'Sarana Pembelajaran',
                        ])
                        ->native(false)
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
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'infrastructure' => 'Sarana Infrastruktur',
                            'learning' => 'Sarana Pembelajaran',
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'infrastructure' => 'info',
                        'learning' => 'warning',
                    })
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
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }
}
