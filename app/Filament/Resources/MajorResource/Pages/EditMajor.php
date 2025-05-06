<?php

namespace App\Filament\Resources\MajorResource\Pages;

use App\Models\Major;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MajorResource;

class EditMajor extends EditRecord
{
    protected static string $resource = MajorResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
