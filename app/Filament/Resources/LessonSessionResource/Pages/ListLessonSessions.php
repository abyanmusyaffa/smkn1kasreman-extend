<?php

namespace App\Filament\Resources\LessonSessionResource\Pages;

use App\Filament\Resources\LessonSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLessonSessions extends ListRecords
{
    protected static string $resource = LessonSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
