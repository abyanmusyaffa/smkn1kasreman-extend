<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructure extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($organizationalStructure) {
            if ($organizationalStructure->photo) {
                Storage::disk('public')->delete($organizationalStructure->photo);
            }
        });
    
        static::updating(function ($organizationalStructure) {
            if ($organizationalStructure->isDirty('photo')) {
                $oldPhoto = $organizationalStructure->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });
    }
}
