<?php

namespace App\Filament\Resources\AttendanceScheduleOverrideResource\Pages;

use App\Filament\Resources\AttendanceScheduleOverrideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceScheduleOverride extends EditRecord
{
    protected static string $resource = AttendanceScheduleOverrideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
