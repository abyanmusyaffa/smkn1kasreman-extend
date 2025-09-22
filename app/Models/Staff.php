<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $guarded = ['id'];

    public function lesson_timetables(): HasMany
    {
        return $this->hasMany(LessonTimetable::class);
    }

    public function school_leaderships(): HasMany
    {
        return $this->hasMany(SchoolLeadership::class);
    }

    public function group_guardians(): HasMany
    {
        return $this->hasMany(GroupGuardian::class);
    }

    protected static function booted()
    {
        static::deleting(function ($staff) {
            if ($staff->photo && ($staff->photo !== '/default/staff-male.svg' && $staff->photo !== '/default/staff-female.svg')) {
                Storage::disk('public')->delete($staff->photo);
            }
        });
    
        static::updating(function ($staff) {
            if ($staff->isDirty('photo')) {
                $oldPhoto = $staff->getOriginal('photo');
                if ($oldPhoto && ($oldPhoto !== '/default/staff-male.svg' && $oldPhoto !== '/default/staff-female.svg')) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });
    }   
}
