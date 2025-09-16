<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentHistory extends Model
{
    protected $guarded = ['id'];

    public function students(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function academic_years(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

}
