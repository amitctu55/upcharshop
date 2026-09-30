<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use BelongsToHospital;

    protected $guarded = [];
    protected $casts = [
        'publish_at' => 'datetime',
        'views'      => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected static function booted(): void
    {
        static::saving(fn ($p) => $p->slug = $p->slug ?: Str::slug($p->title));
    }
}
