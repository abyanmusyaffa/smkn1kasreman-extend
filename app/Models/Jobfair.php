<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jobfair extends Model
{
    protected $casts = [
        'industry' => 'json',
    ];

    protected $guarded = ['id'];
    
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::deleting(function ($jobfair) {
            if ($jobfair->photo) {
                Storage::disk('public')->delete($jobfair->photo);
            }
        });
    
        static::updating(function ($jobfair) {
            if ($jobfair->isDirty('photo')) {
                $oldPhoto = $jobfair->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });


        static::updating(function ($jobfair) {
            $originalContent = $jobfair->getOriginal('content');
            $newContent = $jobfair->content;

            preg_match_all('/attachments-jobfair\/[^"\' ]+/', $originalContent, $originalFiles);
            preg_match_all('/attachments-jobfair\/[^"\' ]+/', $newContent, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($jobfair) {
            preg_match_all('/attachments-jobfair\/[^"\' ]+/', $jobfair->content, $files);

            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }   
}
