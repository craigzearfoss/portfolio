<?php

namespace App\Models\System;

use App\Models\System;
use App\Models\System\User;
use App\Models\System\UserUserTeam;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserGroup extends Model
{
    use SearchableModelTrait, Notifiable, SoftDeletes;

    protected $connection = 'system_db';

    protected $table = 'user_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'user_team_id',
        'name',
        'slug',
        'abbreviation',
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
    const array SEARCH_COLUMNS = ['id', 'user_id', 'user_team_id', 'name', 'abbreviation', 'public', 'readonly', 'root',
        'disabled', 'demo'];
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
            ->when(isset($filters['user_team_id']), function ($query) use ($filters) {
                $query->where('user_team_id', '=', intval($filters['user_team_id']));
            })
            ->when(!empty($filters['abbreviation']), function ($query) use ($filters) {
                $query->where('abbreviation', '=', $filters['abbreviation']);
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
    }

    /**
     * Get the system user of the user group.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(System\User::class, 'owner_id');
    }

    /**
     * Get the system user team that owns the user group.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(UserTeam::class, 'user_team_id');
    }

    /**
     * Get the members for the user group.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->orderBy('name', 'asc');
    }
}
