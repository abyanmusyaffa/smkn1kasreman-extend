<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StudentEvent extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::updating(function ($studentEvent) {
            // Hapus photo lama jika berubah dan bukan default
            if ($studentEvent->isDirty('photo')) {
                $oldPhoto = $studentEvent->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
    
            // Hapus attachment yang dihapus dari description
            $originalDescription = $studentEvent->getOriginal('description');
            $newDescription = $studentEvent->description;
    
            preg_match_all('/student-events\/[^"\']+/', $originalDescription, $originalFiles);
            preg_match_all('/student-events\/[^"\']+/', $newDescription, $newFiles);
    
            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);
    
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    
        static::deleting(function ($studentEvent) {
            // Hapus photo jika bukan default
            if ($studentEvent->photo) {
                Storage::disk('public')->delete($studentEvent->photo);
            }
    
            // Hapus semua attachment dari description
            preg_match_all('/student-events\/[^"\']+/', $studentEvent->description, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
