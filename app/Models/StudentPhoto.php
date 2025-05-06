<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentPhoto extends Model
{
    protected $casts = [
        'photos' => 'json',
    ];

    protected $guarded = ['id'];

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    protected static function booted()
    {
        static::deleting(function ($studentPhoto) {
            if ($studentPhoto->photos) {
                foreach ($studentPhoto->photos as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        });
    
        static::updating(function ($studentPhoto) {
            $originalPhotos = $studentPhoto->getOriginal('photos') ?? [];
            $newPhotos = $studentPhoto->photos ?? [];
    
            $filesToDelete = array_diff($originalPhotos, $newPhotos);
    
            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }
}
