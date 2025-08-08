<?php

namespace App\Filament\Resources\LessonTimetableResource\Pages;

use App\Filament\Resources\LessonTimetableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLessonTimetable extends EditRecord
{
    protected static string $resource = LessonTimetableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
