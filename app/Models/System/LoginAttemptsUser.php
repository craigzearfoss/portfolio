<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class LoginAttemptsUser extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'admin_name', 'admin_username', 'admin_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'user_id', 'username', 'action', 'ip_address', 'success', 'created_at' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'created_at', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'all' => [
            'admin_id|asc'    => 'admin_id',
            'action|desc'     => 'action',
            'created_at|desc' => 'datetime created',
            'updated_at|desc' => 'datetime updated',
            'id|asc'          => 'id',
            'ip_address|asc'  => 'ip_address',
            'username|asc'    => 'username',
        ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }
}
