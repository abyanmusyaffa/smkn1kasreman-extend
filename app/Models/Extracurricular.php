<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Extracurricular extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($extracurricular) {
            if ($extracurricular->logo && $extracurricular->logo !== '/default/extracurricular.svg') {
                Storage::disk('public')->delete($extracurricular->logo);
            }
        });
    
        static::updating(function ($extracurricular) {
            if ($extracurricular->isDirty('logo')) {
                $oldLogo = $extracurricular->getOriginal('logo');
                if ($oldLogo && $extracurricular->logo !== '/default/extracurricular.svg') {
                    Storage::disk('public')->delete($oldLogo);
                }
            }
        });
    }   
}
