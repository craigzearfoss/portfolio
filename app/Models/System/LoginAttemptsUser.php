<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class LoginAttemptsUser extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

    protected $table = 'login_attempts_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'username',
        'action',
        'ip_address',
        'success',
        'created_at',
        'updated_at',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'user_id', 'username', 'action', 'ip_address', 'success', 'created_at'];
    const array SEARCH_ORDER_BY = ['created_at', 'desc'];
}
