<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HospitalScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        // 1) Public site: tenant bound by middleware
        if (app()->bound('current.hospital')) {
            $builder->where($model->getTable().'.hospital_id', app('current.hospital')->id);
            return;
        }

        // 2) Admin panel: scope by the logged-in staff member's hospital
        $user = auth()->user();
        if ($user && $user->hospital_id) {
            $builder->where($model->getTable().'.hospital_id', $user->hospital_id);
        }
        // 3) Super admin: no scope — sees everything
    }
}
