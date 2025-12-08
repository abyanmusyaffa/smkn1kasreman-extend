<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WhatsAppService
{
    protected $token;
    protected $url;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->url = config('services.fonnte.url');
    }

    /**
     * Send WhatsApp message (DIRECT - NO QUEUE)
     */
    public function send($phone, $message)
    {
        try {
            $phone = $this->formatPhone($phone);

            if (!$phone) {
                return [
                    'success' => false,
                    'message' => 'Nomor tidak valid'
                ];
            }

            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => $this->token,
                ])
                ->post($this->url, [
                    'target' => $phone,
                    'message' => $message,
                ]);

            if ($response->successful()) {
                Log::info('WhatsApp sent successfully', [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);

                return [
                    'success' => true,
                    'message' => 'Pesan terkirim',
                    'data' => $response->json()
                ];
            }

            Log::error('WhatsApp failed', [
                'phone' => $phone,
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal mengirim pesan',
                'data' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp exception', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send check-in notification (DIRECT)
     */
    public function sendCheckInNotification($student, $attendance, $studentHistory)
    {
        $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i');
        $date = Carbon::parse($attendance->check_in_time)->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $status = $this->getStatusText($attendance->status);
        $statusEmoji = $this->getStatusEmoji($attendance->status);

        $message = "{$statusEmoji} *PRESENSI MASUK*\n\n";
        $message .= "Nama: *{$student->name}*\n";
        $message .= "NIS: {$student->nis}\n";
        $message .= "Kelas: {$studentHistory->groups->name}\n";
        $message .= "Waktu: {$checkInTime} WIB\n";
        $message .= "Status: *{$status}*\n";
        $message .= "Tanggal: {$date}\n\n";
        $message .= "_Pesan otomatis dari sistem presensi sekolah_";

        $phones = $this->collectPhones($student);

        foreach ($phones as $phone) {
            $this->send($phone, $message);
        }

        return true;
    }

    /**
     * Send check-out notification (DIRECT)
     */
    public function sendCheckOutNotification($student, $attendance, $studentHistory)
    {
        $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i');
        $checkOutTime = Carbon::parse($attendance->check_out_time)->format('H:i');
        $date = Carbon::parse($attendance->check_in_time)->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $message = "🟢 *PRESENSI PULANG*\n\n";
        $message .= "Nama: *{$student->name}*\n";
        $message .= "NIS: {$student->nis}\n";
        $message .= "Kelas: {$studentHistory->groups->name}\n";
        $message .= "Masuk: {$checkInTime} WIB\n";
        $message .= "Pulang: {$checkOutTime} WIB\n";
        $message .= "Tanggal: {$date}\n\n";
        $message .= "_Pesan otomatis dari sistem presensi sekolah_";

        $phones = $this->collectPhones($student);

        foreach ($phones as $phone) {
            $this->send($phone, $message);
        }

        return true;
    }

    /**
     * Send late notification (DIRECT)
     */
    public function sendLateNotification($student, $attendance, $studentHistory, $lateMinutes)
    {
        $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i');
        $date = Carbon::parse($attendance->check_in_time)->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $message = "⚠️ *PRESENSI MASUK TERLAMBAT*\n\n";
        $message .= "Nama: *{$student->name}*\n";
        $message .= "NIS: {$student->nis}\n";
        $message .= "Kelas: {$studentHistory->groups->name}\n";
        $message .= "Masuk: {$checkInTime} WIB\n";
        $message .= "Keterlambatan: *{$lateMinutes} menit*\n";
        $message .= "Tanggal: {$date}\n\n";
        $message .= "_Pesan otomatis dari sistem presensi sekolah_";

        $phones = $this->collectPhones($student);

        foreach ($phones as $phone) {
            $this->send($phone, $message);
        }

        return true;
    }

    protected function formatPhone($phone)
    {
        if (empty($phone)) return null;

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = ltrim($phone, '0');

        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    protected function collectPhones($student)
    {
        $phones = [];

        if (!empty($student->phone)) $phones[] = $student->phone;
        if (!empty($student->father_phone)) $phones[] = $student->father_phone;
        if (!empty($student->mother_phone)) $phones[] = $student->mother_phone;
        if (!empty($student->guardian_phone)) $phones[] = $student->guardian_phone;

        return array_unique(array_filter($phones));
    }

    protected function getStatusText($status)
    {
        return [
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'missing' => 'Tidak Presensi Pulang',
            'sick' => 'Sakit',
            'excused' => 'Izin',
        ][$status] ?? $status;
    }

    protected function getStatusEmoji($status)
    {
        return [
            'present' => '✅',
            'late' => '⚠️',
            'missing' => '❌',
            'sick' => '🏥',
            'excused' => '📝',
        ][$status] ?? '📌';
    }
}
// namespace App\Services;

// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;
// use Carbon\Carbon;

// class WhatsAppService
// {
//     protected $token;
//     protected $url;

//     public function __construct()
//     {
//         $this->token = config('services.fonnte.token');
//         $this->url = config('services.fonnte.url');
//     }

//     /**
//      * Send WhatsApp message
//      */
//     public function send($phone, $message)
//     {
//         try {
//             // Format phone number
//             $phone = $this->formatPhone($phone);

//             $response = Http::timeout(10)
//                 ->withHeaders([
//                     'Authorization' => $this->token,
//                 ])
//                 ->post($this->url, [
//                     'target' => $phone,
//                     'message' => $message,
//                     'countryCode' => '62',
//                 ]);

//             if ($response->successful()) {
//                 Log::info('WhatsApp sent successfully', [
//                     'phone' => $phone,
//                     'response' => $response->json()
//                 ]);
//                 return [
//                     'success' => true,
//                     'message' => 'Pesan terkirim',
//                     'data' => $response->json()
//                 ];
//             }

//             Log::error('WhatsApp failed', [
//                 'phone' => $phone,
//                 'status' => $response->status(),
//                 'response' => $response->json()
//             ]);
            
//             return [
//                 'success' => false,
//                 'message' => 'Gagal mengirim pesan',
//                 'data' => $response->json()
//             ];

//         } catch (\Exception $e) {
//             Log::error('WhatsApp exception', [
//                 'phone' => $phone,
//                 'error' => $e->getMessage()
//             ]);
            
//             return [
//                 'success' => false,
//                 'message' => 'Error: ' . $e->getMessage()
//             ];
//         }
//     }

//     /**
//      * Send to multiple phones
//      */
//     public function sendBulk($phones, $message)
//     {
//         $results = [];
        
//         foreach ($phones as $phone) {
//             $results[] = $this->send($phone, $message);
//         }
        
//         return $results;
//     }

//     /**
//      * Format phone number to international format
//      * Input: 0812345678 or 812345678 or 62812345678
//      * Output: 6281234567890
//      */
//     protected function formatPhone($phone)
//     {
//         if (empty($phone)) {
//             return null;
//         }

//         // Remove all non-numeric characters
//         $phone = preg_replace('/[^0-9]/', '', $phone);

//         // Remove leading zeros
//         $phone = ltrim($phone, '0');

//         // Add country code if not present
//         if (substr($phone, 0, 2) !== '62') {
//             $phone = '62' . $phone;
//         }

//         return $phone;
//     }

//     /**
//      * Send check-in notification to student and parent (QUEUE VERSION)
//      */
//     public function sendCheckInNotification($student, $attendance, $studentHistory)
//     {
//         $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i');
//         $date = Carbon::parse($attendance->check_in_time)->locale('id')->isoFormat('dddd, D MMMM YYYY');
//         $status = $this->getStatusText($attendance->status);
//         $statusEmoji = $this->getStatusEmoji($attendance->status);
        
//         $message = "{$statusEmoji} *NOTIFIKASI PRESENSI MASUK*\n\n";
//         $message .= "Nama: *{$student->name}*\n";
//         $message .= "NIS: {$student->nis}\n";
//         $message .= "Kelas: {$studentHistory->groups->name}\n";
//         $message .= "Waktu: {$checkInTime} WIB\n";
//         $message .= "Status: *{$status}*\n";
//         $message .= "Tanggal: {$date}\n\n";
//         $message .= "_Pesan otomatis dari sistem presensi sekolah_";

//         // Collect phone numbers
//         $phones = $this->collectPhones($student);

//         // Add to queue
//         $queueService = app(\App\Services\WhatsAppQueueService::class);
        
//         foreach ($phones as $phone) {
//             if ($phone) {
//                 $queueService->addToQueue($phone, $message, [
//                     'type' => 'check_in',
//                     'student_id' => $student->id,
//                     'attendance_id' => $attendance->id,
//                 ]);
//             }
//         }

//         return true;
//     }

//     /**
//      * Send check-out notification to student and parent (QUEUE VERSION)
//      */
//     public function sendCheckOutNotification($student, $attendance, $studentHistory)
//     {
//         $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i');
//         $checkOutTime = Carbon::parse($attendance->check_out_time)->format('H:i');
//         $date = Carbon::parse($attendance->check_in_time)->locale('id')->isoFormat('dddd, D MMMM YYYY');
        
//         // Calculate duration
//         $duration = Carbon::parse($attendance->check_in_time)
//             ->diffInHours(Carbon::parse($attendance->check_out_time));
//         $durationMinutes = Carbon::parse($attendance->check_in_time)
//             ->diffInMinutes(Carbon::parse($attendance->check_out_time)) % 60;
        
//         $message = "🟢 *NOTIFIKASI PRESENSI PULANG*\n\n";
//         $message .= "Nama: *{$student->name}*\n";
//         $message .= "NIS: {$student->nis}\n";
//         $message .= "Kelas: {$studentHistory->groups->name}\n";
//         $message .= "Masuk: {$checkInTime} WIB\n";
//         $message .= "Pulang: {$checkOutTime} WIB\n";
//         $message .= "Durasi: {$duration} jam {$durationMinutes} menit\n";
//         $message .= "Tanggal: {$date}\n\n";
//         $message .= "_Pesan otomatis dari sistem presensi sekolah_";

//         // Collect phone numbers
//         $phones = $this->collectPhones($student);

//         // Add to queue
//         $queueService = app(\App\Services\WhatsAppQueueService::class);
        
//         foreach ($phones as $phone) {
//             if ($phone) {
//                 $queueService->addToQueue($phone, $message, [
//                     'type' => 'check_out',
//                     'student_id' => $student->id,
//                     'attendance_id' => $attendance->id,
//                 ]);
//             }
//         }

//         return true;
//     }

//     /**
//      * Send late notification (QUEUE VERSION)
//      */
//     public function sendLateNotification($student, $attendance, $studentHistory, $lateMinutes)
//     {
//         $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i');
//         $date = Carbon::parse($attendance->check_in_time)->locale('id')->isoFormat('dddd, D MMMM YYYY');
        
//         $message = "⚠️ *PERINGATAN KETERLAMBATAN*\n\n";
//         $message .= "Nama: *{$student->name}*\n";
//         $message .= "NIS: {$student->nis}\n";
//         $message .= "Kelas: {$studentHistory->groups->name}\n";
//         $message .= "Waktu Datang: {$checkInTime} WIB\n";
//         $message .= "Keterlambatan: *{$lateMinutes} menit*\n";
//         $message .= "Tanggal: {$date}\n\n";
//         $message .= "_Mohon agar anak datang tepat waktu ke sekolah_";

//         // Collect phone numbers
//         $phones = $this->collectPhones($student);

//         // Add to queue
//         $queueService = app(\App\Services\WhatsAppQueueService::class);
        
//         foreach ($phones as $phone) {
//             if ($phone) {
//                 $queueService->addToQueue($phone, $message, [
//                     'type' => 'late',
//                     'student_id' => $student->id,
//                     'attendance_id' => $attendance->id,
//                     'late_minutes' => $lateMinutes,
//                 ]);
//             }
//         }

//         return true;
//     }

//     /**
//      * Send sick/excused notification (when manually created)
//      */
//     public function sendSickExcusedNotification($student, $attendance, $studentHistory)
//     {
//         $date = Carbon::parse($attendance->check_in_time)->locale('id')->isoFormat('dddd, D MMMM YYYY');
//         $status = $this->getStatusText($attendance->status);
//         $statusEmoji = $this->getStatusEmoji($attendance->status);
        
//         $message = "{$statusEmoji} *NOTIFIKASI KETERANGAN*\n\n";
//         $message .= "Nama: *{$student->name}*\n";
//         $message .= "NIS: {$student->nis}\n";
//         $message .= "Kelas: {$studentHistory->groups->name}\n";
//         $message .= "Status: *{$status}*\n";
//         $message .= "Tanggal: {$date}\n";
        
//         if ($attendance->reason) {
//             $message .= "Alasan: {$attendance->reason}\n";
//         }
        
//         $message .= "\n_Keterangan telah dicatat dalam sistem presensi_";

//         // Collect phone numbers
//         $phones = $this->collectPhones($student);

//         // Send to all numbers
//         $results = [];
//         foreach ($phones as $phone) {
//             if ($phone) {
//                 $results[] = $this->send($phone, $message);
//             }
//         }

//         return $results;
//     }

//     /**
//      * Collect all phone numbers (student + parents)
//      */
//     protected function collectPhones($student)
//     {
//         $phones = [];
        
//         // Student phone
//         if (!empty($student->phone)) {
//             $phones[] = $student->phone;
//         }
        
//         // Parent phone
//         // if (!empty($student->parent_phone)) {
//         //     $phones[] = $student->parent_phone;
//         // }
        
//         // Father phone (if exists)
//         if (!empty($student->father_phone)) {
//             $phones[] = $student->father_phone;
//         }
        
//         // Mother phone (if exists)
//         if (!empty($student->mother_phone)) {
//             $phones[] = $student->mother_phone;
//         }

//         // Guardian phone (if exists)
//         if (!empty($student->guardian_phone)) {
//             $phones[] = $student->guardian_phone;
//         }
        
//         return array_unique(array_filter($phones));
//     }

//     /**
//      * Get status text in Indonesian
//      */
//     protected function getStatusText($status)
//     {
//         $statusMap = [
//             'present' => 'Hadir',
//             'late' => 'Terlambat',
//             'missing' => 'Tidak Presensi Pulang',
//             'sick' => 'Sakit',
//             'excused' => 'Izin',
//         ];
        
//         return $statusMap[$status] ?? $status;
//     }

//     /**
//      * Get status emoji
//      */
//     protected function getStatusEmoji($status)
//     {
//         $emojiMap = [
//             'present' => '✅',
//             'late' => '⚠️',
//             'missing' => '❌',
//             'sick' => '🏥',
//             'excused' => '📝',
//         ];
        
//         return $emojiMap[$status] ?? '📌';
//     }
// }