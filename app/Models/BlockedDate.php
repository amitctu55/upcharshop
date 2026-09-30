<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class BlockedDate extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'date' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
