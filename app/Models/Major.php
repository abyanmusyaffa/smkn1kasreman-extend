<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Major extends Model
{
    protected $casts = [
        'galleries' => 'json',
        'contacts' => 'array',
    ];
    
    protected $guarded = ['id'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    protected static function booted()
    {
        static::deleting(function ($major) {
            // hapus logo
            if ($major->logo) {
                Storage::disk('public')->delete($major->logo);
            }

            // hapus galleries
            if ($major->galleries) {
                foreach ($major->galleries as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            // hapus atachments
            preg_match_all('/majors\/[^"\' ]+/', $major->description, $files);

            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    
        static::updating(function ($major) {
            // hapus logo
            if ($major->isDirty('logo')) {
                $oldLogo = $major->getOriginal('logo');
                if ($oldLogo) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }

            // hapus galleries
            $originalGalleries = $major->getOriginal('galleries') ?? [];
            $newGalleries = $major->galleries ?? [];
    
            $filesToDelete = array_diff($originalGalleries, $newGalleries);
    
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            // hapus atactmenets
            $originalDescription = $major->getOriginal('description');
            $newDescription = $major->description;

            preg_match_all('/majors\/[^"\' ]+/', $originalDescription, $originalFiles);
            preg_match_all('/majors\/[^"\' ]+/', $newDescription, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }   
}
