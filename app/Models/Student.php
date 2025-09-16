<?php

namespace App\Models;

use App\Models\StudentHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $guarded = ['id'];

    public function student_histories(): HasMany
    {
        return $this->hasMany(StudentHistory::class);
    }
}
