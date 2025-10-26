<?php

namespace App\Models;

use App\Models\StudentHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $guarded = ['id'];

    public function student_histories(): HasMany
    {
        return $this->hasMany(StudentHistory::class);
    }

    protected static function booted()
    {
        static::deleting(function ($student) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
        });
    
        static::updating(function ($student) {
            if ($student->isDirty('photo')) {
                $oldPhoto = $student->getOriginal('photo');
                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });
    }  
}
