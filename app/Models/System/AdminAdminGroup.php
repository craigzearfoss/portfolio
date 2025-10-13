<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAdminGroup extends Model
{
    /** @use HasFactory<\Database\Factories\AdminAdminGroupFactory> */
    use HasFactory;

    protected $connection = 'system_db';

    protected $table = 'admin_admin_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'admin_group_id',
    ];
}
