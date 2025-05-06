<?php

namespace App\Filament\Resources\StudentPhotoResource\Pages;

use App\Filament\Resources\StudentPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentPhoto extends EditRecord
{
    protected static string $resource = StudentPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
