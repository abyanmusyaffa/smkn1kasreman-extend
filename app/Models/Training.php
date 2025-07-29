<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Training extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::updating(function ($training) {
            // Hapus photo lama jika berubah dan bukan default
            if ($training->isDirty('photo')) {
                $oldPhoto = $training->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
    
            // Hapus attachment yang dihapus dari description
            $originalDescription = $training->getOriginal('description');
            $newDescription = $training->description;
    
            preg_match_all('/trainings\/[^"\']+/', $originalDescription, $originalFiles);
            preg_match_all('/trainings\/[^"\']+/', $newDescription, $newFiles);
    
            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);
    
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    
        static::deleting(function ($training) {
            // Hapus photo jika bukan default
            if ($training->photo) {
                Storage::disk('public')->delete($training->photo);
            }
    
            // Hapus semua attachment dari description
            preg_match_all('/trainings\/[^"\']+/', $training->description, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
