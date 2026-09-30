<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $guarded = [];
    protected $casts = ['changes' => 'array'];

    public static function track(string $action, ?Model $model = null, array $changes = []): void
    {
        static::create([
            'hospital_id' => app()->bound('current.hospital') ? app('current.hospital')->id : auth()->user()?->hospital_id,
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model_type'  => $model?->getMorphClass(),
            'model_id'    => $model?->id,
            'changes'     => $changes ?: null,
            'ip'          => request()->ip(),
        ]);
    }
}
