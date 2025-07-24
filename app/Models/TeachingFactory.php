<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingFactory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'contacts' => 'array',
        'products' => 'array',
        'services' => 'json',
        'galleries' => 'json',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
