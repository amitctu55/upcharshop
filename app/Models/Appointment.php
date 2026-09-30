<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'appointment_date' => 'date',
        'age' => 'integer',
        'token_no' => 'integer',
    ];

    public const STATUSES = ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'];
    public const VISIT_TYPES = ['new', 'followup', 'video'];
    public const SOURCES = ['online', 'walkin', 'phone', 'admin'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
