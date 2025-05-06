<?php

namespace App\Filament\Resources\JobfairResource\Pages;

use App\Filament\Resources\JobfairResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobfair extends EditRecord
{
    protected static string $resource = JobfairResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
