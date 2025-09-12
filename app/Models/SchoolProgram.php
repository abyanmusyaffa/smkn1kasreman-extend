<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SchoolProgram extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'galleries' => 'array',
    ];

    protected static function booted()
    {
        static::updating(function ($schoolProgram) {
            // Hapus photo galleries yang dihapus
            $originalGalleries = $schoolProgram->getOriginal('galleries') ?? [];
            $newGalleries = $schoolProgram->galleries ?? [];

            $originalPhotos = collect($originalGalleries)->pluck('photo')->filter()->toArray();
            $newPhotos = collect($newGalleries)->pluck('photo')->filter()->toArray();

            $filesToDelete = array_diff($originalPhotos, $newPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus attachment yang dihapus dari description
            $originalDescription = $schoolProgram->getOriginal('description');
            $newDescription = $schoolProgram->description;

            preg_match_all('/school-programs\/[^"\']+/', $originalDescription, $originalFiles);
            preg_match_all('/school-programs\/[^"\']+/', $newDescription, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($schoolProgram) {
            // Hapus semua photo galleries
            if ($schoolProgram->galleries) {
                foreach ($schoolProgram->galleries as $galleries) {
                    if (!empty($galleries['photo'])) {
                        Storage::disk('public')->delete($galleries['photo']);
                    }
                }
            }

            // Hapus semua attachment dari description
            preg_match_all('/school-programs\/[^"\']+/', $schoolProgram->description, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
