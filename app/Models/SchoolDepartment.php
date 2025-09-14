<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SchoolDepartment extends Model
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

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function articles(): MorphMany
    {
        return $this->morphMany(Article::class, 'organization');
    }

    protected static function booted()
    {
        static::updating(function ($schoolDepartment) {
            // Hapus photo galleries yang dihapus
            $originalGalleries = $schoolDepartment->getOriginal('galleries') ?? [];
            $newGalleries = $schoolDepartment->galleries ?? [];

            $originalPhotos = collect($originalGalleries)->pluck('photo')->filter()->toArray();
            $newPhotos = collect($newGalleries)->pluck('photo')->filter()->toArray();

            $filesToDelete = array_diff($originalPhotos, $newPhotos);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus attachment yang dihapus dari description
            $originalDescription = $schoolDepartment->getOriginal('description');
            $newDescription = $schoolDepartment->description;

            preg_match_all('/school-departments\/[^"\']+/', $originalDescription, $originalFiles);
            preg_match_all('/school-departments\/[^"\']+/', $newDescription, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($schoolDepartment) {
            // Hapus semua photo galleries
            if ($schoolDepartment->galleries) {
                foreach ($schoolDepartment->galleries as $galleries) {
                    if (!empty($galleries['photo'])) {
                        Storage::disk('public')->delete($galleries['photo']);
                    }
                }
            }

            // Hapus semua attachment dari description
            preg_match_all('/school-departments\/[^"\']+/', $schoolDepartment->description, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
