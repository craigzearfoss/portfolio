<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class LoginAttemptsAdmin extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'admin_name', 'admin_username', 'admin_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'admin_id', 'username', 'action', 'ip_address', 'success', 'created_at',
        'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'created_at', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'admin_id|asc'    => 'admin_id',
        'action|desc'     => 'action',
        'created_at|desc' => 'datetime created',
        'updated_at|desc' => 'datetime updated',
        'id|asc'          => 'id',
        'ip_address|asc'  => 'ip_address',
        'username|asc'    => 'username',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'admin_id', 'action', 'id', 'ip_address', 'username', ],
        'guest' => [ 'admin_id', 'action', 'id', 'ip_address', 'username', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }
}
