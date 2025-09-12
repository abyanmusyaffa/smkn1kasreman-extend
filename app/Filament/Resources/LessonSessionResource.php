<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LessonSession;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LessonSessionResource\Pages;
use App\Filament\Resources\LessonSessionResource\RelationManagers;
use Filament\Forms\Components\Select;

class LessonSessionResource extends Resource
{
    protected static ?string $model = LessonSession::class;

    protected static ?string $modelLabel = 'Sesi Pelajaran';
    protected static ?string $pluralModelLabel = 'Sesi Pelajaran';

    protected static ?string $navigationGroup = 'Kurikulum';
    protected static ?string $navigationIcon = 'fas-clock';

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
                    Forms\Components\TextInput::make('number')
                        ->label('Nomor Sesi')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\Select::make('type')
                        ->label('Tipe Hari')
                        ->required()
                        ->native(false)
                        ->options([
                            'monday-thursday' => 'Senin-Kamis',
                            'friday' => 'Jumat'
                        ])
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 8,
                        ]),
                    Forms\Components\TimePicker::make('start_time')
                        ->label('Jam Mulai')
                        ->required()
                        ->seconds(false)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TimePicker::make('end_time')
                        ->label('Jam Selesai')
                        ->required()
                        ->seconds(false)
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
                Tables\Columns\TextColumn::make('number')
                    ->label('Nomor Sesi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->time()
                    ->label('Jam Mulai')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->time()
                    ->label('Jam Selesai')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'monday' => 'danger',
                        'tuesday-thursday' => 'info',
                        'friday' => 'warning',
                    })
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'monday' => 'Senin',
                            'tuesday-thursday' => 'Selasa-Kamis',
                            'friday' => 'Jumat',
                        };
                    })
                    ->label('Tipe Hari')
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
            'index' => Pages\ListLessonSessions::route('/'),
            'create' => Pages\CreateLessonSession::route('/create'),
            'edit' => Pages\EditLessonSession::route('/{record}/edit'),
        ];
    }
}
