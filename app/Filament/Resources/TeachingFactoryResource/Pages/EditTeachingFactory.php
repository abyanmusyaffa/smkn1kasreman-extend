<?php

namespace App\Filament\Resources\TeachingFactoryResource\Pages;

use App\Filament\Resources\TeachingFactoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeachingFactory extends EditRecord
{
    protected static string $resource = TeachingFactoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
