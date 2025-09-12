<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Partner;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PartnerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PartnerResource\RelationManagers;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;
    protected static ?string $modelLabel = 'Mitra DU/DI';
    protected static ?string $pluralModelLabel = 'Mitra DU/DI';

    protected static ?string $navigationGroup = 'Humas';
    protected static ?string $navigationIcon = 'fas-building-circle-check';

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
                        ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter') 
                        ->maxLength(56)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('logo')
                        ->label('Logo')
                        ->image()
                        ->default('/default/extracurricular.svg')
                        ->directory('/partners')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Textarea::make('address')
                        ->label('Alamat')
                        ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter') 
                        ->maxLength(128)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TagsInput::make('industry')
                        ->label('Bidang Industri')
                        ->splitKeys(['Tab'])
                        ->suggestions([
                            'Teknologi Informasi',
                            'Perbankan',
                            'Tekstil',
                            'Akuntansi',
                            'FnB',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold)
                    ->wrap()
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->wrap()
                    ->label('Alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('industry')
                    ->label('Bidang Industri')
                    ->badge()
                    ->color('info')
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->size(ActionSize::Large)
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
