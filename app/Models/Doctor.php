<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'video_consult' => 'boolean',
        'is_featured'   => 'boolean',
        'status'        => 'boolean',
        'social_links'  => 'array',
        'consultation_fee' => 'decimal:2',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function blockedDates()
    {
        return $this->hasMany(BlockedDate::class);
    }

    protected static function booted(): void
    {
        static::saving(fn ($d) => $d->slug = $d->slug ?: Str::slug($d->name));
    }
}
