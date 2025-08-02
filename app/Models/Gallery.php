<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'galleries' => 'array',
    ];

    protected static function booted()
    {
        static::updating(function ($gallery) {
            // Hapus photo galleries yang dihapus
            $originalGalleries = $gallery->getOriginal('galleries') ?? [];
            $newGalleries = $gallery->galleries ?? [];

            $originalPhotos = collect($originalGalleries)->pluck('photo')->filter()->toArray();
            $newPhotos = collect($newGalleries)->pluck('photo')->filter()->toArray();

            $filesToDelete = array_diff($originalPhotos, $newPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($gallery) {
            // Hapus semua photo galleries
            if ($gallery->galleries) {
                foreach ($gallery->galleries as $galleries) {
                    if (!empty($galleries['photo'])) {
                        Storage::disk('public')->delete($galleries['photo']);
                    }
                }
            }
        });
    }
}
