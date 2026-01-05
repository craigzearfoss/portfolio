<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use App\Models\System\UserUserTeam;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserTeam extends Model
{
    /** @use HasFactory<\Database\Factories\UserTeamFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'system_db';

    protected $table = 'user_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'abbreviation',
        'slug',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'abbreviation', 'public', 'readonly', 'root', 'disabled',
        'demo',
    ];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the system owner of the user team.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the system user groups for the user team.
     */
    public function groups(): hasMany
    {
        return $this->hasMany(UserGroup::class, 'user_team_id');
    }

    /**
     * Returns the members of the user team.
     *
     * @return Collection
     */
    public function members(): Collection
    {
        return UserUserTeam::select('users.*')
            ->where('user_user_teams.user_team_id', $this->id)
            ->join('users', 'users.id', '=', 'user_user_teams.user_id')
            ->get();
    }
}
