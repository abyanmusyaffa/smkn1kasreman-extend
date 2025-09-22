<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\AttendanceSchedule;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AttendanceScheduleResource\Pages;
use App\Filament\Resources\AttendanceScheduleResource\RelationManagers;

class AttendanceScheduleResource extends Resource
{
    protected static ?string $model = AttendanceSchedule::class;

    protected static ?string $modelLabel = 'Jadwal Presensi';
    protected static ?string $pluralModelLabel = 'Jadwal Presensi';

    protected static ?string $navigationGroup = 'Presensi';
    protected static ?string $navigationIcon = 'fas-clipboard-list';

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
                    Forms\Components\Select::make('day')
                        ->label('Hari')
                        ->options([
                            'monday' => 'Senin',
                            'tuesday' => 'Selasa',
                            'wednesday' => 'Rabu',
                            'thursday' => 'Kamis',
                            'friday' => 'Jumat',
                        ])
                        ->native(false)
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TimePicker::make('check_in_start')
                        ->label('Jam Masuk Mulai')
                        ->seconds(false)
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TimePicker::make('check_in_end')
                        ->label('Jam Masuk Selesai')
                        ->seconds(false)
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TimePicker::make('check_out_start')
                        ->label('Jam Pulang Mulai')
                        ->seconds(false)
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TimePicker::make('check_out_end')
                        ->label('Jam Pulang Selesai')
                        ->seconds(false)
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
                Tables\Columns\TextColumn::make('day')
                    ->label('Hari')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'monday' => 'Senin',
                            'tuesday' => 'Selasa',
                            'wednesday' => 'Rabu',
                            'thursday' => 'Kamis',
                            'friday' => 'Jumat',
                        };
                    }),
                Tables\Columns\TextColumn::make('check_in_start')
                    ->badge()
                    ->alignCenter()
                    ->color('info')    
                    ->label('Jam Masuk Mulai'),
                Tables\Columns\TextColumn::make('check_in_end')
                    ->badge()
                    ->alignCenter()
                    ->color('info')    
                    ->label('Jam Masuk Selesai'),
                Tables\Columns\TextColumn::make('check_out_start')
                    ->badge()
                    ->alignCenter()
                    ->color('success')    
                    ->label('Jam Pulang Mulai'),
                Tables\Columns\TextColumn::make('check_out_end')
                    ->badge()
                    ->alignCenter()
                    ->color('success')    
                    ->label('Jam Pulang Selesai'),
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
            'index' => Pages\ListAttendanceSchedules::route('/'),
            'create' => Pages\CreateAttendanceSchedule::route('/create'),
            'edit' => Pages\EditAttendanceSchedule::route('/{record}/edit'),
        ];
    }
}
