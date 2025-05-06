<?php

namespace App\Filament\Resources\ScoreCategoryResource\Pages;

use App\Filament\Resources\ScoreCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScoreCategories extends ListRecords
{
    protected static string $resource = ScoreCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
