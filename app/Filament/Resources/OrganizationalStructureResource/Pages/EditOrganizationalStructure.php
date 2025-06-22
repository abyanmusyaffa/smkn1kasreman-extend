<?php

namespace App\Filament\Resources\OrganizationalStructureResource\Pages;

use App\Filament\Resources\OrganizationalStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationalStructure extends EditRecord
{
    protected static string $resource = OrganizationalStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
