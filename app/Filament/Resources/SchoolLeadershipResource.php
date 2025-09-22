<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SchoolLeadership;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SchoolLeadershipResource\Pages;
use App\Filament\Resources\SchoolLeadershipResource\RelationManagers;

class SchoolLeadershipResource extends Resource
{
    protected static ?string $model = SchoolLeadership::class;

    protected static ?string $modelLabel = 'Pimpinan Sekolah';
    protected static ?string $pluralModelLabel = 'Pimpinan Sekolah';

    protected static ?string $navigationGroup = 'Sekolah';
    protected static ?string $navigationIcon = 'fas-people-line';

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
                    
                    Forms\Components\Select::make('staff_id')
                        ->label('GTK')
                        ->relationship('staff', 'name')
                        ->required()
                        ->searchable()
                        ->native(false)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('role')
                        ->label('Jabatan')
                        ->required()
                        ->maxLength(255)
                        ->live()
                        ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter')
                        ->maxLength(24)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'head-master' => 'Kepala Sekolah',
                            'vice-master' => 'Wakil Kepala Sekolah',
                            'head-of-major' => 'Kakomli',
                        ])
                        ->native(false)
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
                Tables\Columns\TextColumn::make('staff.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Jabatan')
                    ->searchable()
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
            'index' => Pages\ListSchoolLeaderships::route('/'),
            'create' => Pages\CreateSchoolLeadership::route('/create'),
            'edit' => Pages\EditSchoolLeadership::route('/{record}/edit'),
        ];
    }
}
