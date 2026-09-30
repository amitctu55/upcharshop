<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'show_in_menu' => 'boolean',
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(fn ($p) => $p->slug = $p->slug ?: Str::slug($p->title));
    }
}
