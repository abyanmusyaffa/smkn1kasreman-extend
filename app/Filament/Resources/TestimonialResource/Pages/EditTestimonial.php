<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestimonial extends EditRecord
{
    protected static string $resource = TestimonialResource::class;

    protected function beforeSave(): void
    {
        $data = $this->form->getState();
    
        if ($data['type'] === 'text') {
            $this->record->url = null;
        } elseif ($data['type'] === 'url') {
            $this->record->content = null;
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
