<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function alumnis(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }
    
    public function majors(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function student_photos(): HasOne
    {
        return $this->hasone(StudentPhoto::class);
    }
}
