<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use App\Models\OrganizationalStructure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrganizationalStructureResource\Pages;
use App\Filament\Resources\OrganizationalStructureResource\RelationManagers;

class OrganizationalStructureResource extends Resource
{
    protected static ?string $model = OrganizationalStructure::class;

    protected static ?string $modelLabel = 'Struktur Organisasi';
    protected static ?string $pluralModelLabel = 'Struktur Organisasi';

    protected static ?string $navigationGroup = 'Sekolah';
    protected static ?string $navigationIcon = 'fas-network-wired';

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
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Gambar')
                        ->image()
                        ->directory('/organizational-structures')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi')
                        ->required()
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
            'index' => Pages\ListOrganizationalStructures::route('/'),
            'create' => Pages\CreateOrganizationalStructure::route('/create'),
            'edit' => Pages\EditOrganizationalStructure::route('/{record}/edit'),
        ];
    }
}
