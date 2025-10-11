<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUserTeam extends Model
{
    /** @use HasFactory<\Database\Factories\UserUserTeamFactory> */
    use HasFactory;

    protected $connection = 'core_db';

    protected $table = 'user_user_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'user_team_id',
    ];
}
