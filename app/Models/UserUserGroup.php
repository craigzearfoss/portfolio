<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUserGroup extends Model
{
    /** @use HasFactory<\Database\Factories\UserUserGroupFactory> */
    use HasFactory;

    protected $connection = 'core_db';

    protected $table = 'user_user_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'user_group_id',
    ];
}
