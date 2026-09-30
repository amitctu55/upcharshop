<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use BelongsToHospital;

    protected $guarded = [];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
