<?php

namespace App\Filament\Resources\StudentPhotoResource\Pages;

use Filament\Actions;
use App\Models\Alumni;
use App\Models\StudentPhoto;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StudentPhotoResource;

class ListStudentPhotos extends ListRecords
{
    protected static string $resource = StudentPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
