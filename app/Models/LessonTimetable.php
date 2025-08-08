<?php

namespace App\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonTimetable extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'lesson_session' => 'array',
    ];

    public function subjects(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function rooms(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
