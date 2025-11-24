<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminGlobalScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $routeName = Route::currentRouteName();

        if (explode('.', $routeName)[0] == 'admin') {

            // this is an admin route
            if (isRootAdmin()) {
                $admin = Auth::guard('admin')->user();
                $builder->where($model->getTable().'.owner_id', $admin->id);
            }

        } else {

            // this is a user or guest route
            $builder->where('public', 1)->where('disabled', 0);
        }
    }
}
