<?php

namespace App\Models;

use App\Models\LessonTimetable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function lesson_timetables(): HasMany
    {
        return $this->hasMany(LessonTimetable::class);
    }

    protected static function booted()
    {
        static::updating(function ($room) {
            // Hapus photo lama jika berubah dan bukan default
            if ($room->isDirty('photo')) {
                $oldPhoto = $room->getOriginal('photo');
                if ($oldPhoto && $oldPhoto !== '/default/room.svg') {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });

        static::deleting(function ($room) {
            // Hapus photo jika bukan default
            if ($room->photo && $room->photo !== '/default/room.svg') {
                Storage::disk('public')->delete($room->photo);
            }
        });
    }
}
