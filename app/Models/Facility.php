<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Facility extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($facility) {
            if ($facility->photo) {
                Storage::disk('public')->delete($facility->photo);
            }
        });
    
        static::updating(function ($facility) {
            if ($facility->isDirty('photo')) {
                $oldPhoto = $facility->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });
    }   
}
