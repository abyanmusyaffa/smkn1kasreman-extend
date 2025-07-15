<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Internship extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'galleries' => 'json',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function articles(): MorphMany
    {
        return $this->morphMany(Article::class, 'organization');
    }

    protected static function booted()
    {
        static::updating(function ($internship) {
            // Hapus galleries yang dihapus dari array
            $originalGalleries = $internship->getOriginal('galleries') ?? [];
            $newGalleries = $internship->galleries ?? [];

            $filesToDelete = array_diff($originalGalleries, $newGalleries);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // Hapus attachment yang dihapus dari description
            $originalDescription = $internship->getOriginal('description');
            $newDescription = $internship->description;
    
            preg_match_all('/internships\/[^"\']+/', $originalDescription, $originalFiles);
            preg_match_all('/internships\/[^"\']+/', $newDescription, $newFiles);
    
            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);
    
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    
        static::deleting(function ($internship) {
            // Hapus semua galleries
            if ($internship->galleries) {
                foreach ($internship->galleries as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            // Hapus semua attachment dari description
            preg_match_all('/internships\/[^"\']+/', $internship->description, $files);
            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
