<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryCategory extends Model
{
    use BelongsToHospital;

    protected $guarded = [];

    public function items() { return $this->hasMany(Gallery::class); }
    public function galleries() { return $this->hasMany(Gallery::class); }

    protected static function booted(): void
    {
        static::saving(fn ($m) => $m->slug = $m->slug ?: Str::slug($m->name));
    }
}
