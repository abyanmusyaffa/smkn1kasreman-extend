<?php

namespace App\Filament\Resources\GroupGuardianResource\Pages;

use App\Filament\Resources\GroupGuardianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupGuardian extends EditRecord
{
    protected static string $resource = GroupGuardianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
