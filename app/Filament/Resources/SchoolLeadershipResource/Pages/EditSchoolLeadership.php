<?php

namespace App\Filament\Resources\SchoolLeadershipResource\Pages;

use App\Filament\Resources\SchoolLeadershipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolLeadership extends EditRecord
{
    protected static string $resource = SchoolLeadershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
