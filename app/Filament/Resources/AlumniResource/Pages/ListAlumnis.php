<?php

namespace App\Filament\Resources\AlumniResource\Pages;

use Filament\Actions;
use App\Models\Alumni;
use App\Models\StudentPhoto;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Filament\Imports\AlumniImporter;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AlumniResource;

class ListAlumnis extends ListRecords
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('syncPhotos')
                ->label('Sinkronisasi Foto Siswa')
                ->requiresConfirmation()
                ->action(function () {
                    DB::beginTransaction();

                    try {
                        $photoGroups = StudentPhoto::with('groups')->get();
                        $updated = 0;

                        foreach ($photoGroups as $photoGroup) {
                            $photos = $photoGroup->photos; // array of filenames
                            $group = $photoGroup->groups;

                            foreach ($photos as $photoFile) {
                                $prefix = substr(pathinfo($photoFile, PATHINFO_FILENAME), 0, 4);
                                
                                $alumni = Alumni::where('nis', 'like', $prefix . '%')
                                    ->where('group_id', $group->id)
                                    ->first();

                                if ($alumni && $alumni->photo !== $photoFile) {
                                    $alumni->update(['photo' => $photoFile]);
                                    $updated++;
                                }
                            }
                        }

                        DB::commit();

                        Notification::make()
                            ->title("Sinkronisasi selesai: $updated foto diperbarui")
                            ->success()
                            ->send();

                    } catch (\Exception $e) {
                        DB::rollBack();

                        Notification::make()
                            ->title('Gagal sinkronisasi: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->color('info'),
            Actions\ImportAction::make()
                ->label('Impor Siswa')
                ->importer(AlumniImporter::class)
                ->maxRows(300) // Sesuaikan batas maksimum baris
                ->chunkSize(100), // Ukuran chunk untuk processing
        ];
    }
}
