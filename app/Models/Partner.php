<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    protected $casts = [
        'industry' => 'json',
    ];

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($partner) {
            if ($partner->logo && $partner->logo !== '/default/extracurricular.svg') {
                Storage::disk('public')->delete($partner->logo);
            }
        });
    
        static::updating(function ($partner) {
            if ($partner->isDirty('logo')) {
                $oldLogo = $partner->getOriginal('logo');
                if ($oldLogo && $partner->logo !== '/default/extracurricular.svg') {
                    Storage::disk('public')->delete($oldLogo);
                }
            }
        });
    }
}
