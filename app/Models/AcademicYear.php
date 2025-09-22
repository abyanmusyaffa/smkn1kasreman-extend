<?php

namespace App\Models;

use App\Models\GroupGuardian;
use App\Models\StudentHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    protected $guarded = ['id'];

    public function student_histories(): HasMany
    {
        return $this->hasMany(StudentHistory::class);
    }

    public function group_guardians(): HasMany
    {
        return $this->hasMany(GroupGuardian::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->is_active) {
                static::where('id', '!=', $model->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
