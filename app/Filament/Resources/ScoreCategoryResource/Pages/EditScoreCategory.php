<?php

namespace App\Filament\Resources\ScoreCategoryResource\Pages;

use App\Filament\Resources\ScoreCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScoreCategory extends EditRecord
{
    protected static string $resource = ScoreCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
