<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];
}
