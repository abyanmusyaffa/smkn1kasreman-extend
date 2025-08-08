<?php

namespace App\Filament\Resources\LessonTimetableResource\Pages;

use App\Models\Group;
use Filament\Actions;
use App\Models\LessonTimetable;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\GroupResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\LessonTimetableResource;

class CreateLessonTimetable extends CreateRecord
{
    protected static string $resource = LessonTimetableResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        foreach ($data['timetables'] as $item) {
            LessonTimetable::create([
                'group_id' => $data['group_id'],
                'day' => $item['day'],
                'lesson_session' => $item['lesson_session'],
                'subject_id' => $item['subject_id'],
                'staff_id' => $item['staff_id'],
                'room_id' => $item['room_id'],
            ]);
        }

        // Kembalikan model dummy agar tidak error
        return new LessonTimetable();
    }
}
