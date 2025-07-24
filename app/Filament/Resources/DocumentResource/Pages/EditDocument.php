<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function beforeSave(): void
    {
        $data = $this->form->getState();

        if ($data['type'] === 'file') {
            $this->record->url = null;
        } elseif ($data['type'] === 'url') {
            $this->record->file = null;
        }
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
