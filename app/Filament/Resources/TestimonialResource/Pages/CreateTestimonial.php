<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestimonial extends CreateRecord
{
    protected static string $resource = TestimonialResource::class;

    protected function beforeValidate(): void
    {
        $data = $this->form->getState();
    
        if ($data['type'] === 'text') {
            $this->form->fill([...$data, 'url' => null]);
        } elseif ($data['type'] === 'url') {
            $this->form->fill([...$data, 'content' => null]);
        }
    }
}
