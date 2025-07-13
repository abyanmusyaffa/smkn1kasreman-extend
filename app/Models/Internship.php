<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Internship extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'galleries' => 'json',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function articles(): MorphMany
    {
        return $this->morphMany(Article::class, 'organization');
    }
}
