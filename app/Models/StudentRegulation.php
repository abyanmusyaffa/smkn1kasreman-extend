<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StudentRegulation extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::updating(function ($studentRegulation) {
            // Hapus attachment yang dihapus dari student_regulation
            $originalStudentRegulation = $studentRegulation->getOriginal('student_regulation');
            $newStudentRegulation = $studentRegulation->student_regulation;

            preg_match_all('/student_regulations\/[^"\']+/', $originalStudentRegulation, $originalFiles);
            preg_match_all('/student_regulations\/[^"\']+/', $newStudentRegulation, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($studentRegulation) {
            // Hapus semua attachment dari student_regulation
            preg_match_all('/student_regulations\/[^"\']+/', $studentRegulation->student_regulation, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
