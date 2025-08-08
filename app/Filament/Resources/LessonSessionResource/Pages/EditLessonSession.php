<?php

namespace App\Filament\Resources\LessonSessionResource\Pages;

use App\Filament\Resources\LessonSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLessonSession extends EditRecord
{
    protected static string $resource = LessonSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
