<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AdminGlobalScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($admin = Auth::guard('admin')->user()) {
            if (!isRootAdmin()) {
                $builder->where($model->getTable().'.owner_id', $admin->id);
            }
        }
    }
}
