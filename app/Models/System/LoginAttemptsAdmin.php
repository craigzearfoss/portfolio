<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class LoginAttemptsAdmin extends Model
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
        'admin_id',
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
    const SEARCH_COLUMNS = ['id', 'admin_id', 'username', 'action', 'ip_address', 'success', 'created_at'];
    const SEARCH_ORDER_BY = ['created_at', 'desc'];
}
