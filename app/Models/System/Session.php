<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

    protected $table = 'sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'user_id', 'admin_id', 'ip_address', 'user_agent', 'payload', 'last_activity'];
    const SEARCH_ORDER_BY = ['last_activity', 'desc'];
}
