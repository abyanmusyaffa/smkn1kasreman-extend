<?php

namespace App\Filament\Resources\SchoolDepartmentResource\Pages;

use App\Filament\Resources\SchoolDepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolDepartment extends EditRecord
{
    protected static string $resource = SchoolDepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
