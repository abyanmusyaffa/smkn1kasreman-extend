<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AttendanceScheduleOverride;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AttendanceScheduleOverrideResource\Pages;
use App\Filament\Resources\AttendanceScheduleOverrideResource\RelationManagers;

class AttendanceScheduleOverrideResource extends Resource
{
    protected static ?string $model = AttendanceScheduleOverride::class;

    protected static ?string $modelLabel = 'Jadwal Presensi Khusus';
    protected static ?string $pluralModelLabel = 'Jadwal Presensi Khusus';

    protected static ?string $navigationGroup = 'Presensi';
    protected static ?string $navigationIcon = 'fas-clipboard';

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
                    Forms\Components\DatePicker::make('date')
                        ->label('Tanggal Berlaku')
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
                    Forms\Components\Textarea::make('reason')
                        ->label('Keterangan')
                        ->rows(2)
                        ->required()
                        ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->translatedFormat('l, d F Y'))
                    ->sortable(),
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
            'index' => Pages\ListAttendanceScheduleOverrides::route('/'),
            'create' => Pages\CreateAttendanceScheduleOverride::route('/create'),
            'edit' => Pages\EditAttendanceScheduleOverride::route('/{record}/edit'),
        ];
    }
}
