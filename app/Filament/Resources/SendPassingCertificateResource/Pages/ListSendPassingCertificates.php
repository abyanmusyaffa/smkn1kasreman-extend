<?php

namespace App\Filament\Resources\SendPassingCertificateResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\Alumni;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Models\SendPassingCertificate;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SendPassingCertificateResource;

class ListSendPassingCertificates extends ListRecords
{
    protected static string $resource = SendPassingCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('syncPassingCertificates')
                ->label('Sinkronisasi Siswa')
                ->requiresConfirmation()
                ->action(function () {
                    DB::beginTransaction();
                    
                    try {
                        $alumnis = Alumni::with(['scores.subjects.score_categories', 'send_passing_certificates'])->get();

                        foreach ($alumnis as $alumni) {
                            if ($alumni->send_passing_certificates) {
                                continue; 
                            }

                            $scoreCount = $alumni->scores->count();
                            $major = strtolower($alumni->groups->majors->alias);

                            $requiredScore = in_array($major, ['kl']) ? 17 : 16;

                            if ($scoreCount >= $requiredScore && $alumni->photo !== null) {
                                SendPassingCertificate::create([
                                    'alumni_id' => $alumni->id,
                                    'number' => null,
                                    'date' => null,
                                ]);
                            }
                        }

                        DB::commit();

                        Notification::make()
                            ->title('Sinkronisasi selesai')
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
        ];
    }
}
