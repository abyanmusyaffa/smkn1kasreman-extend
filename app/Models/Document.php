<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($document) {
            if ($document->file) {
                Storage::disk('public')->delete($document->file);
            }
        });
    
        static::updating(function ($document) {
            if ($document->isDirty('file')) {
                $oldFile = $document->getOriginal('file');
                if ($oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }
        });
    }   
}