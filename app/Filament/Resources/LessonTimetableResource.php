<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use App\Models\Group;
use App\Models\Staff;
use App\Models\Subject;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LessonSession;
use App\Models\LessonTimetable;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LessonTimetableResource\Pages;
use App\Filament\Resources\LessonTimetableResource\RelationManagers;

class LessonTimetableResource extends Resource
{
    protected static ?string $model = LessonTimetable::class;

    protected static ?string $modelLabel = 'Jadwal Pelajaran';
    protected static ?string $pluralModelLabel = 'Jadwal Pelajaran';

    protected static ?string $navigationGroup = 'Jadwal Pelajaran';
    protected static ?string $navigationIcon = 'fas-calendar-alt';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Section::make()
    //             ->columns([
    //                 'default' => 2,
    //                 'lg' => 12,
    //             ])
    //             ->schema([
    //                 Forms\Components\Select::make('group_id')
    //                     ->label('Kelas')
    //                     ->required()
    //                     ->native(false)
    //                     ->default(fn () => request()->query('group_id'))
    //                     ->options(Group::all()->pluck('name', 'id'))
    //                     ->searchable()
    //                     ->reactive()
    //                     ->afterStateUpdated(fn (callable $set) => $set('subject_id', null))
    //                     ->columnSpan([
    //                         'default' => 2,
    //                         'lg' => 6,
    //                     ]),
    //                 Forms\Components\Select::make('staff_id')
    //                     ->label('Guru')
    //                     ->native(false)
    //                     ->options(Staff::where('category', 'teacher')->orderBy('name')->pluck('name', 'id'))
    //                     ->searchable()
    //                     ->columnSpan([
    //                         'default' => 2,
    //                         'lg' => 6,
    //                     ]),
    //                 Forms\Components\Select::make('subject_id')
    //                     ->label('Mata Pelajaran')
    //                     ->native(false)
    //                     ->options(Subject::all()->pluck('name', 'id'))
    //                     ->searchable()
    //                     ->columnSpan([
    //                         'default' => 2,
    //                         'lg' => 12,
    //                     ]),
    //                 Forms\Components\Select::make('day')
    //                     ->label('Hari')
    //                     ->native(false)
    //                     ->options([
    //                         'monday' => 'Senin',
    //                         'tuesday' => 'Selasa',
    //                         'wednesday' => 'Rabu',
    //                         'thursday' => 'Kamis',
    //                         'friday' => 'Jumat',
    //                     ])
    //                     ->required()
    //                     ->reactive()
    //                     ->columnSpan([
    //                         'default' => 2,
    //                         'lg' => 4,
    //                     ]),
    //                 Forms\Components\CheckboxList::make('lesson_session')
    //                     ->label('Sesi Pelajaran')
    //                     ->options(function (Get $get): array {
    //                         $day = $get('day');
    //                         if (!$day) return [];
                    
    //                         $type = in_array($day, ['monday', 'tuesday', 'wednesday', 'thursday']) ? 'monday-thursday' : 'friday';
                    
    //                         return LessonSession::where('type', $type)
    //                             ->orderBy('start_time')
    //                             ->get()
    //                             ->mapWithKeys(function ($lessonSession) {
    //                                 return [
    //                                     $lessonSession->id => "{$lessonSession->number} ({$lessonSession->start_time} - {$lessonSession->end_time})"
    //                                 ];
    //                             })
    //                             ->toArray();
    //                     })
    //                     ->required()
    //                     ->columnSpan([
    //                         'default' => 2,
    //                         'lg' => 8,
    //                     ]),
    //             ])
    //         ]);
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('group_id')
                            ->label('Kelas')
                            ->required()
                            ->native(false)
                            ->relationship(name: 'groups', titleAttribute: 'name')
                            ->searchable()
                            ->columnSpanFull(),

                        Repeater::make('timetables')
                            ->label('Jadwal Pelajaran')
                            ->schema([
                                Select::make('day')
                                    ->label('Hari')
                                    ->required()
                                    ->native(false)
                                    ->options([
                                        'monday' => 'Senin',
                                        'tuesday' => 'Selasa',
                                        'wednesday' => 'Rabu',
                                        'thursday' => 'Kamis',
                                        'friday' => 'Jumat',
                                    ])
                                    ->reactive()
                                    ->columnSpan(4),

                                CheckboxList::make('lesson_session')
                                    ->label('Sesi')
                                    ->options(function (Get $get): array {
                                        $day = $get('day');
                                        if (!$day) return [];

                                        $type = in_array($day, ['tuesday', 'wednesday', 'thursday']) ? 'tuesday-thursday' : ( $day === 'monday' ? 'monday' : 'friday' );

                                        return LessonSession::where('type', $type)->where('number', 'not like', '%istirahat%')
                                            ->orderBy('start_time')
                                            ->get()
                                            ->mapWithKeys(fn ($s) => [
                                                $s->id => "{$s->number} ({$s->start_time}-{$s->end_time})"
                                            ])
                                            ->toArray();
                                    })
                                    ->required()
                                    ->columns(2)
                                    ->columnSpan(8),

                                Select::make('subject_id')
                                    ->label('Mata Pelajaran')
                                    ->native(false)
                                    ->relationship(name: 'subjects', titleAttribute: 'name')
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(12),

                                Select::make('staff_id')
                                    ->label('Guru')
                                    ->options(Staff::where('category', 'teacher')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(6),

                                Select::make('room_id')
                                    ->label('Ruang')
                                    ->options(Room::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->columnSpan(6),
                            ])
                            ->columns(12)
                            ->columnSpanFull()
                            ->minItems(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Group::whereHas('lesson_timetables') 
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Kelas'),
                // Tables\Columns\TextColumn::make('timetables_count')
                //     ->label('Jumlah Jadwal')
                //     ->counts('lesson_timetables'),
            ])
            ->actions([
                Action::make('kelola')
                    ->label('Ubah')
                    ->url(fn (Group $record): string => static::getUrl('edit', ['record' => $record->id]))
                    ->icon('fas-edit')
                    ->color('warning'),
                Action::make('hapus_jadwal')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Semua Jadwal')
                    ->modalDescription(fn (Group $record) => "Apakah Anda yakin ingin menghapus semua jadwal untuk kelas {$record->name} ? Tindakan ini tidak dapat dibatalkan.")
                    ->modalSubmitActionLabel('Ya, Hapus Semua')
                    ->modalCancelActionLabel('Batal')
                    ->action(function (Group $record) {
                        try {
                            $deletedCount = LessonTimetable::where('group_id', $record->id)->count();
                            LessonTimetable::where('group_id', $record->id)->delete();
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Berhasil!')
                                ->body("Berhasil menghapus {$deletedCount} jadwal untuk kelas {$record->name}")
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Terjadi kesalahan!')
                                ->body('Gagal menghapus jadwal: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }
    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             Tables\Columns\TextColumn::make('subjects.name')
    //                 ->label('Mata Pelajaran')
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('groups.name')
    //                 ->label('Kelas')
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('staff.name')
    //                 ->label('Guru')
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('day')
    //                 ->label('Hari')
    //                 ->formatStateUsing(function (string $state) {
    //                     return match ($state) {
    //                         'monday' => 'Senin',
    //                         'tuesday' => 'Selasa',
    //                         'wednesday' => 'Rabu',
    //                         'thursday' => 'Kamis',
    //                         'friday' => 'Jumat',
    //                     };
    //                 })
    //                 ->sortable()
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('lesson_session')
    //                 ->label('Sesi')
    //                 ->html()
    //                 ->getStateUsing(function ($record) {
    //                     if (!$record->lesson_session || !is_array($record->lesson_session)) {
    //                         return '-';
    //                     }
                
    //                     $sessions = LessonSession::whereIn('id', $record->lesson_session)->get();
                
    //                     $formatted = $sessions
    //                         ->map(fn($s) => "<div class='block'>{$s->number} ( {$s->start_time} - {$s->end_time} )</div>")
    //                         ->join('');
                
    //                     return $formatted;
    //                 }),
    //             Tables\Columns\TextColumn::make('created_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             Tables\Columns\TextColumn::make('updated_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make(),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessonTimetables::route('/'),
            'create' => Pages\CreateLessonTimetable::route('/create'),
            // 'edit' => Pages\EditLessonTimetable::route('/{record}/edit'),
            'edit' => Pages\ManageLessonTimetable::route('/{record}/edit'),
        ];
    }
}
