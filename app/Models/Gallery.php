<?php

namespace App\Models;

use App\Models\Concerns\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use BelongsToHospital;

    protected $table = 'galleries';
    protected $guarded = [];
    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }
}
