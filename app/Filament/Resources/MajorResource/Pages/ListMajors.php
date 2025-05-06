<?php

namespace App\Filament\Resources\MajorResource\Pages;

use App\Models\Major;
use Filament\Actions;
use App\Filament\Resources\MajorResource;
use Filament\Resources\Pages\ListRecords;

class ListMajors extends ListRecords
{
    protected static string $resource = MajorResource::class;

    protected function getHeaderActions(): array
    {
        $majorsCount = Major::count();

        return $majorsCount < 4 ? [
            Actions\CreateAction::make(),
        ] : [];

        // return [
        //     Actions\CreateAction::make(),
        // ];
    }
}
