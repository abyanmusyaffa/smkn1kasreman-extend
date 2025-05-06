<?php

namespace App\Filament\Resources\SendPassingCertificateResource\Pages;

use App\Filament\Resources\SendPassingCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSendPassingCertificate extends EditRecord
{
    protected static string $resource = SendPassingCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
