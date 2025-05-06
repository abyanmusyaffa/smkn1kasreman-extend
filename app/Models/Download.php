<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Download extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::updating(function ($download) {
            $originalContent = $download->getOriginal('content');
            $newContent = $download->content;

            preg_match_all('/attachments-download\/[^"\' ]+/', $originalContent, $originalFiles);
            preg_match_all('/attachments-download\/[^"\' ]+/', $newContent, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($download) {
            preg_match_all('/attachments-download\/[^"\' ]+/', $download->content, $files);

            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }  
}
