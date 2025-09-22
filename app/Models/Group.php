<?php

namespace App\Models;

use App\Models\StudentHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    // public function alumnis(): HasMany
    // {
    //     return $this->hasMany(Alumni::class);
    // }
    public function student_histories(): HasMany
    {
        return $this->hasMany(StudentHistory::class);
    }

    public function group_guardians(): HasMany
    {
        return $this->hasMany(GroupGuardian::class);
    }
    
    public function majors(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function student_photos(): HasOne
    {
        return $this->hasone(StudentPhoto::class);
    }

    public function lesson_timetables(): HasMany
    {
        return $this->hasMany(LessonTimetable::class);
    }
}
