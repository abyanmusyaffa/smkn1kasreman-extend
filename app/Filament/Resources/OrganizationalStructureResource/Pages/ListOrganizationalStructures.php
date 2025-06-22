<?php

namespace App\Filament\Resources\OrganizationalStructureResource\Pages;

use App\Filament\Resources\OrganizationalStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationalStructures extends ListRecords
{
    protected static string $resource = OrganizationalStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
