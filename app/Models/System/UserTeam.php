<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserTeam extends Model
{
    use SearchableModelTrait, Notifiable, SoftDeletes;

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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'abbreviation', 'public', 'readonly', 'root', 'disabled',
        'demo',
    ];
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        return self::getSearchQuery($filters)
            ->when(isset($filters['user_id']), function ($query) use ($filters) {
                $query->where('user_id', '=', intval($filters['user_id']));
            })
            ->when(!empty($filters['abbreviation']), function ($query) use ($filters) {
                $query->where('abbreviation', '=', $filters['abbreviation']);
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
    }

    /**
     * Get the system owner of the user team.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the members for the user team.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->orderBy('name');
    }

    /**
     * Get the system user groups for the user team.
     */
    public function groups(): hasMany
    {
        return $this->hasMany(UserGroup::class, 'user_team_id');
    }
}
