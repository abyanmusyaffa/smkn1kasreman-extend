<?php

namespace App\Filament\Resources\LessonTimetableResource\Pages;

use App\Models\Room;
use App\Models\Group;
use App\Models\Staff;
use App\Models\Subject;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Actions\Action;
use App\Models\LessonSession;
use App\Models\LessonTimetable;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\LessonTimetableResource;

class ManageLessonTimetable extends Page
{
    protected static string $resource = LessonTimetableResource::class;

    protected static string $view = 'filament.resources.lesson-timetable-resource.pages.manage-lesson-timetable';

    public ?array $data = [];
    public Group $group;

    protected static ?string $title = 'Kelola Jadwal Pelajaran';

    public function mount(int $record): void
    {
        $this->group = Group::findOrFail($record);
        
        // Load existing timetables
        $existingTimetables = LessonTimetable::where('group_id', $this->group->id)
            ->with(['subjects', 'staff', 'rooms'])
            ->get();

        $formattedTimetables = $existingTimetables->map(function ($timetable) {
            return [
                'id' => $timetable->id,
                'day' => $timetable->day,
                'lesson_session' => $timetable->lesson_session,
                'subject_id' => $timetable->subject_id,
                'staff_id' => $timetable->staff_id,
                'room_id' => $timetable->room_id,
            ];
        })->toArray();

        $this->form->fill([
            'group_id' => $this->group->id,
            'timetables' => $formattedTimetables,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        // TextInput::make('name')
                        //     ->label('Kelas')
                        //     ->default($this->groups->name ?? '')
                        //     ->disabled()
                        //     ->dehydrated(false)
                        //     ->columnSpanFull(),

                        Repeater::make('timetables')
                            ->label('')
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
                                    ->options(Subject::all()->pluck('name', 'id'))
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
                            ->minItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(function (array $state): ?string {
                                $dayLabel = match($state['day'] ?? null) {
                                    'monday' => 'Senin',
                                    'tuesday' => 'Selasa', 
                                    'wednesday' => 'Rabu',
                                    'thursday' => 'Kamis',
                                    'friday' => 'Jumat',
                                    default => 'Jadwal Baru'
                                };

                                $subject = $state['subject_id'] ? Subject::find($state['subject_id'])?->name : '';
                                
                                return $subject ? "{$dayLabel} - {$subject}" : $dayLabel;
                            }),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                // ->icon('heroicon-o-arrow-left')
                ->color('black')
                ->url($this->getResource()::getUrl('index')),
            Action::make('save')
                ->label('Simpan Jadwal')
                ->icon('heroicon-o-check')
                ->color('warning')
                ->action('save'),
            
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        try {
            // Delete existing timetables for this group
            LessonTimetable::where('group_id', $this->group->id)->delete();

            // Create new timetables
            foreach ($data['timetables'] as $timetableData) {
                if (!empty($timetableData['day']) && !empty($timetableData['subject_id']) && !empty($timetableData['staff_id'])) {
                    LessonTimetable::create([
                        'group_id' => $this->group->id,
                        'day' => $timetableData['day'],
                        'lesson_session' => $timetableData['lesson_session'],
                        'subject_id' => $timetableData['subject_id'],
                        'staff_id' => $timetableData['staff_id'],
                        'room_id' => $timetableData['room_id'],
                    ]);
                }
            }

            Notification::make()
                ->title('Berhasil!')
                ->body('Jadwal pelajaran berhasil disimpan!')
                ->success()
                ->send();
            
            // Refresh the form with updated data
            $this->mount($this->group->id);
            
        } catch (\Exception $e) {
            Notification::make()
                ->title('Terjadi kesalahan!')
                ->body('Gagal menyimpan jadwal: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function getBreadcrumbs(): array
    {
        return [
            $this->getResource()::getUrl() => $this->getResource()::getBreadcrumb(),
            '#' => 'Kelola Jadwal - ' . $this->group->name,
        ];
    }

    public function getTitle(): string
    {
        return 'Kelola Jadwal Pelajaran - ' . $this->group->name;
    }
}
