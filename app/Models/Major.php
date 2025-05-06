<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $casts = [
        'photo' => 'json',
    ];
    
    protected $guarded = ['id'];

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
            if ($major->logo) {
                Storage::disk('public')->delete($major->logo);
            }
        });
    
        static::updating(function ($major) {
            if ($major->isDirty('logo')) {
                $oldLogo = $major->getOriginal('logo');
                if ($oldLogo) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }
        });


        static::deleting(function ($major) {
            if ($major->photo) {
                foreach ($major->photo as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        });
    
        static::updating(function ($major) {
            $originalPhotos = $major->getOriginal('photo') ?? [];
            $newPhotos = $major->photo ?? [];
    
            $filesToDelete = array_diff($originalPhotos, $newPhotos);
    
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });


        static::updating(function ($major) {
            $originalDescription = $major->getOriginal('description');
            $newDescription = $major->description;

            preg_match_all('/attachments-major\/[^"\' ]+/', $originalDescription, $originalFiles);
            preg_match_all('/attachments-major\/[^"\' ]+/', $newDescription, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($major) {
            preg_match_all('/attachments-major\/[^"\' ]+/', $major->description, $files);

            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }   
}
