<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
}
