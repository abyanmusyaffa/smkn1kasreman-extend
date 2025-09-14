<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Unit extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'contacts' => 'array',
        'galleries' => 'array',
        'staff' => 'array',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function school_departments(): BelongsTo
    {
        return $this->belongsTo(SchoolDepartment::class, 'school_department_id');
    }

    public function articles(): MorphMany
    {
        return $this->morphMany(Article::class, 'organization');
    }

    protected static function booted()
    {
        static::updating(function ($unit) {
            // Hapus photo galleries yang dihapus
            $originalGalleries = $unit->getOriginal('galleries') ?? [];
            $newGalleries = $unit->galleries ?? [];

            $originalPhotos = collect($originalGalleries)->pluck('photo')->filter()->toArray();
            $newPhotos = collect($newGalleries)->pluck('photo')->filter()->toArray();

            $filesToDelete = array_diff($originalPhotos, $newPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus attachment yang dihapus dari description
            $originalDescription = $unit->getOriginal('description');
            $newDescription = $unit->description;

            preg_match_all('/units\/[^"\']+/', $originalDescription, $originalFiles);
            preg_match_all('/units\/[^"\']+/', $newDescription, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($unit) {
            // Hapus semua photo galleries
            if ($unit->galleries) {
                foreach ($unit->galleries as $galleries) {
                    if (!empty($galleries['photo'])) {
                        Storage::disk('public')->delete($galleries['photo']);
                    }
                }
            }

            // Hapus semua attachment dari description
            preg_match_all('/units\/[^"\']+/', $unit->description, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
