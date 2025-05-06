<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $casts = [
        'photo' => 'json',
    ];

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($photo) {
            if ($photo->photo) {
                foreach ($photo->photo as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        });
    
        static::updating(function ($photo) {
            $originalPhotos = $photo->getOriginal('photo') ?? [];
            $newPhotos = $photo->photo ?? [];
    
            $filesToDelete = array_diff($originalPhotos, $newPhotos);
    
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
