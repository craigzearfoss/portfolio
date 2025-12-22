<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminResource extends Model
{
    protected $connection = 'system_db';

    protected $table = 'admin_resource';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'resource_id',
        'public',
        'readonly',
        'disabled',
        'sequence',
    ];
}
