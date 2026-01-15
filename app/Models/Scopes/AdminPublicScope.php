<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class AdminPublicScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $routeName = Route::currentRouteName();

        if (explode('.', $routeName)[0] == 'admin') {

            // this is an admin route
            if (!isRootAdmin()) {
                if (!$admin = loggedInAdmin()) {
                    // admin is probably logged out
                    return false;
                } else {
                    if (Schema::connection($model->connection)->hasColumn($model->table, 'owner_id')) {
                        $builder->where($model->getTable() . '.owner_id', $admin->id);
                    }
                }
            }

        } else {

            // this is a user or guest route
            $builder->where('public', 1)->where('disabled', 0);
        }
    }
}
