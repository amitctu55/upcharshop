<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'rating' => 'integer',
        'status' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
