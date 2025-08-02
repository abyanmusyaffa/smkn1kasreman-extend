<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class School extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'hero_photos' => 'json',
    ];

    protected static function booted()
    {
        static::updating(function ($school) {
            // Hapus logo lama jika berubah dan bukan default
            if ($school->isDirty('logo')) {
                $oldLogo = $school->getOriginal('logo');
                if ($oldLogo) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }

            // Hapus hero_photos yang dihapus dari array
            $originalHeroPhotos = $school->getOriginal('hero_photos') ?? [];
            $newHeroPhotos = $school->hero_photos ?? [];

            $filesToDelete = array_diff($originalHeroPhotos, $newHeroPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($school) {
            // Hapus logo jika bukan default
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }

            // Hapus semua hero_photos
            if ($school->hero_photos) {
                foreach ($school->hero_photos as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        });
    }

    // protected static function booted()
    // {
    //     static::deleting(function ($school) {
    //         if ($school->logo) {
    //             Storage::disk('public')->delete($school->logo);
    //         }
    //     });
    
    //     static::updating(function ($school) {
    //         if ($school->isDirty('logo')) {
    //             $oldLogo = $school->getOriginal('logo');
    //             if ($oldLogo) {
    //                 Storage::disk('public')->delete($oldLogo);
    //             }
    //         }
    //     });
    // }   
}
