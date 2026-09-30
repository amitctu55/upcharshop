<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Department extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'services' => 'array',
        'seo' => 'array',
        'is_featured' => 'boolean',
        'status' => 'boolean',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    protected static function booted(): void
    {
        static::saving(fn ($d) => $d->slug = $d->slug ?: Str::slug($d->name));
    }
}
