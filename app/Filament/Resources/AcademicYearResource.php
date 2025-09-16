<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AcademicYearResource\Pages;
use App\Filament\Resources\AcademicYearResource\RelationManagers;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static ?string $modelLabel = 'Tahun Ajar';
    protected static ?string $pluralModelLabel = 'Tahun Ajar';

    protected static ?string $navigationGroup = 'Siswa';
    protected static ?string $navigationIcon = 'fas-calendar-week';

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
                        ->label('Tahun Ajar')
                        ->placeholder('2025/2026')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 8,
                        ]),
                    Forms\Components\Select::make('semester')
                        ->required()
                        ->native(false)
                        ->options([
                            '1' => '1 (Ganjil)',
                            '2' => '2 (Genap)',
                        ])
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
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
                    ->label('Tahun Ajar')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'info',
                        '2' => 'success',
                    })
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            '1' => '1 (Ganjil)',
                            '2' => '2 (Genap)',
                            default => ucfirst($state),
                        };
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->alignCenter()
                    ->label('Aktif')
                    ->boolean(),
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
            'index' => Pages\ListAcademicYears::route('/'),
            'create' => Pages\CreateAcademicYear::route('/create'),
            'edit' => Pages\EditAcademicYear::route('/{record}/edit'),
        ];
    }
}
