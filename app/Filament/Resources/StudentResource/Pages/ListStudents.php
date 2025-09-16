<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use App\Filament\Imports\StudentImporter;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StudentResource;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->label('Impor Siswa')
                ->importer(StudentImporter::class)
                ->maxRows(300)
                ->chunkSize(50),
        ];
    }
}
