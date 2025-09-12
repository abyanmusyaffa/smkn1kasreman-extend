<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoomResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoomResource\RelationManagers;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $modelLabel = 'Ruangan';
    protected static ?string $pluralModelLabel = 'Ruangan';

    protected static ?string $navigationGroup = 'Sarpras';
    protected static ?string $navigationIcon = 'fas-building-user';

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
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 7,
                        ]),
                    Forms\Components\TextInput::make('code')
                        ->label('Kode')
                        ->unique(ignoreRecord:true)
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 2,
                        ]),
                    Forms\Components\Select::make('type')
                        ->label('Tipe')
                        ->native(false)
                        ->options([
                            'lab' => 'Lab',
                            'workshop' => 'Bengkel',
                            'classroom' => 'Kelas',
                            'other' => 'Lainnya',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\FileUpload::make('photo')
                        ->hint('Foto Rasio Aspek 4:3 | Landscape')
                        ->default('/default/room.svg')
                        ->directory('rooms')
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('4:3')
                        ->imageResizeTargetWidth('768')
                        ->imageResizeTargetHeight('576')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Textarea::make('description')
                        ->rows(6)
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
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->searchable()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'lab' => 'Lab',
                        'workshop' => 'Bengkel',
                        'classroom' => 'Kelas',
                        'other' => 'Lainnya',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'lab' => 'danger',
                        'workshop' => 'warning',
                        'classroom' => 'success',
                        'other' => 'info',
                    })
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
