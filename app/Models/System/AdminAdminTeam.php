<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAdminTeam extends Model
{
    /** @use HasFactory<\Database\Factories\AdminAdminTeamFactory> */
    use HasFactory;

    protected $connection = 'system_db';

    protected $table = 'admin_admin_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'admin_team_id',
    ];
}
