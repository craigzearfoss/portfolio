<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
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

    protected $connection = 'core_db';

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
        'disabled',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'abbreviation'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the owner of the user team.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the user groups for the user team.
     */
    public function groups(): hasMany
    {
        return $this->hasMany(UserGroup::class);
    }
}
