<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScoreCategory extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
