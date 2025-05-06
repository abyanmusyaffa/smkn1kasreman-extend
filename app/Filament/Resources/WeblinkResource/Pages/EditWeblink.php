<?php

namespace App\Filament\Resources\WeblinkResource\Pages;

use App\Filament\Resources\WeblinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeblink extends EditRecord
{
    protected static string $resource = WeblinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
