<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class School extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($school) {
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }
        });
    
        static::updating(function ($school) {
            if ($school->isDirty('logo')) {
                $oldLogo = $school->getOriginal('logo');
                if ($oldLogo) {
                    Storage::disk('public')->delete($oldLogo);
                }
            }
        });
    }   
}
