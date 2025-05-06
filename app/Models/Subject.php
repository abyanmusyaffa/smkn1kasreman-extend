<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function score_categories(): BelongsTo
    {
        return $this->belongsTo(ScoreCategory::class, 'score_category_id');
    }

    public function majors(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}
