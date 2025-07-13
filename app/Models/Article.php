<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $casts = [
        'tags' => 'json',
    ];

    protected $guarded = ['id'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization()
    {
        return $this->morphTo();
    }


    protected static function booted()
    {
        static::deleting(function ($article) {
            if ($article->photo) {
                Storage::disk('public')->delete($article->photo);
            }
        });
    
        static::updating(function ($article) {
            if ($article->isDirty('photo')) {
                $oldPhoto = $article->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });


        static::updating(function ($article) {
            $originalContent = $article->getOriginal('content');
            $newContent = $article->content;

            preg_match_all('/attachments-article\/[^"\' ]+/', $originalContent, $originalFiles);
            preg_match_all('/attachments-article\/[^"\' ]+/', $newContent, $newFiles);

            $filesToDelete = array_diff($originalFiles[0] ?? [], $newFiles[0] ?? []);

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }
        });

        static::deleting(function ($article) {
            preg_match_all('/attachments-article\/[^"\' ]+/', $article->content, $files);

            foreach ($files[0] ?? [] as $file) {
                Storage::disk('public')->delete($file);
            }
        });
    }   
}
