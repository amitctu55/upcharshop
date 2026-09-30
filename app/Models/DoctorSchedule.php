<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_active' => 'boolean',
        'day_of_week' => 'integer',
        'slot_duration_override' => 'integer',
        'max_per_slot' => 'integer',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getDayNameAttribute(): string
    {
        return match ($this->day_of_week) {
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            default => 'Unknown',
        };
    }
}
