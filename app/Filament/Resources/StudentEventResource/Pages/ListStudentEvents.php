<?php

namespace App\Filament\Resources\StudentEventResource\Pages;

use App\Filament\Resources\StudentEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentEvents extends ListRecords
{
    protected static string $resource = StudentEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
