<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $casts = [
        'tags' => 'json',
    ];

    protected $guarded = ['id'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::deleting(function ($achievement) {
            if ($achievement->photo) {
                Storage::disk('public')->delete($achievement->photo);
            }
        });
    
        static::updating(function ($achievement) {
            if ($achievement->isDirty('photo')) {
                $oldPhoto = $achievement->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });


        static::updating(function ($achievement) {
            $originalContent = $achievement->getOriginal('content');
            $newContent = $achievement->content;

            preg_match_all('/attachments-achievement\/[^"\' ]+/', $originalContent, $originalFiles);
            preg_match_all('/attachments-achievement\/[^"\' ]+/', $newContent, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($achievement) {
            preg_match_all('/attachments-achievement\/[^"\' ]+/', $achievement->content, $files);

            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }  
}
