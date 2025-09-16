<?php

namespace App\Filament\Resources\StudentHistoryResource\Pages;

use App\Filament\Resources\StudentHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentHistory extends EditRecord
{
    protected static string $resource = StudentHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
