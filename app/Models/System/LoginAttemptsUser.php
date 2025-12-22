<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class LoginAttemptsUser extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

    protected $table = 'login_attempts_admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'user_id',
        'ip_address',
        'action',
        'success',
        'created_at',
        'updated_at',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'user_id', 'ip_address', 'action', 'success', 'created_at'];
    const SEARCH_ORDER_BY = ['created_at', 'desc'];
}
