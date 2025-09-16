<?php

namespace App\Models;

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
