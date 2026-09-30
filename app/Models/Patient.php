<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'dob' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
