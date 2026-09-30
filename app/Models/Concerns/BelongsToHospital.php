<?php

namespace App\Models\Concerns;

use App\Models\Hospital;
use App\Models\Scopes\HospitalScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToHospital
{
    protected static function bootBelongsToHospital(): void
    {
        static::addGlobalScope(new HospitalScope);

        // Auto-stamp hospital_id — admin can NEVER leak data across hospitals
        static::creating(function ($model) {
            if (! $model->hospital_id) {
                if (app()->bound('current.hospital')) {
                    $model->hospital_id = app('current.hospital')->id;
                } elseif (auth()->user()?->hospital_id) {
                    $model->hospital_id = auth()->user()->hospital_id;
                }
            }
        });
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }
}
