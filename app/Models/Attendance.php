<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $guarded = ['id'];

    public function student_histories(): BelongsTo
    {
        return $this->belongsTo(StudentHistory::class, 'student_history_id');
    }
}
