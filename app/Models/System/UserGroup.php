<?php

namespace App\Models\System;

use App\Models\System;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 *
 */
class UserGroup extends Model
{
    use SearchableModelTrait, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
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
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'user_name', 'user_username', 'user_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'user_id', 'user_team_id', 'name', 'abbreviation', 'description',
        'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'abbreviation|asc'   => 'abbreviation',
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'id|asc'             => 'id',
        'name|asc'           => 'name',
        'sequence|asc'       => 'sequence',
        'user_username|asc'  => 'owner',
        'user_id|asc'        => 'owner id',
        'user_team_name|asc' => 'team',
        'user_team_id|asc'   => 'team id',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'abbreviation', 'name', 'user_team_name', ],
        'guest' => [ 'abbreviation', 'name', 'user_team_name', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param string|null $sort - column for sort order, append "|asc" or "|desc" to specify direction
     * @param Admin|Owner|null $owner
     * @param User|null $user
     * @return Builder
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = $this->getSearchQuery($filters, false)
            ->when(!empty($filters['abbreviation']), function ($query) use ($filters) {
                $query->where($this->table . '.abbreviation', '=', $filters['abbreviation']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['user_id']), function ($query) use ($filters) {
                $query->where($this->table . '.user_id', '=', intval($filters['user_id']));
            })
            ->when(!empty($filters['user_team_id']), function ($query) use ($filters) {
                $query->where($this->table . '.user_team_id', '=', intval($filters['user_team_id']));
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Get the members for the user group.
     *
     * @return BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->orderBy('name');
    }

    /**
     * Get the system user team that owns the user group.
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(UserTeam::class, 'user_team_id');
    }

    /**
     * Get the system user (owner) of the user group.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(System\User::class, 'owner_id');
    }
}
