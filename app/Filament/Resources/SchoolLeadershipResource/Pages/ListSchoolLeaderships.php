<?php

namespace App\Filament\Resources\SchoolLeadershipResource\Pages;

use App\Filament\Resources\SchoolLeadershipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchoolLeaderships extends ListRecords
{
    protected static string $resource = SchoolLeadershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
