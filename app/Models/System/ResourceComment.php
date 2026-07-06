<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceComment extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'resource_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'resource_class_id',
        'resource_id',
        'owner_id',
        'user_id',
        'text',
        'ip_address',
        'rating',
        'up_count',
        'down_count',
        'approved',
        'hidden',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_username', 'resource_class_name', 'resource_name', 'user_username'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'resource_class_id', 'resource_id', 'user_id', 'rating',
        'up_count', 'down_count', 'approved', 'hidden'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'created_at', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'approved|desc'       => 'approved',
        'created_at|desc'     => 'datetime created',
        'down_count|desc'     => 'down count',
        'hidden|desc'         => 'hidden',
        'id|asc'              => 'id',
        'ip_address|asc'      => 'ip address',
        'owner_id|asc'        => 'owner id',
        'owner_name|asc'      => 'owner name',
        'rating|desc'         => 'rating',
        'resource_id|asc'     => 'resource id',
        'resource_name|asc'   => 'resource name',
        //'text|asc'            => 'text',
        'up_count|desc'       => 'up count',
        'updated_at|desc'     => 'datetime updated',
        'user_id|asc'         => 'user id',
        'user_name|asc'       => 'username',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root owners in the owner area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'owner' => [ 'owner_name', 'datetime_created', 'ip_address', 'rating', 'resource_name', 'user_name', ],
        'guest' => [ 'owner_name', 'datetime_created', 'ip_address', 'rating', 'resource_name', 'user_name', ],
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
     * @throws Exception
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = $this->getSearchQuery($filters, false)
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['favorites']), function ($query) use ($filters) {
                $query->whereIn($this->table . '.id', explode('|', $filters['favorites']));
            })
            ->when(!empty($filters['ip_address']), function ($query) use ($filters) {
                $query->where($this->table . '.ip_address', '=', $filters['ip_address']);
            })
            ->when(!empty($filters['label']), function ($query) use ($filters) {
                $query->where($this->table . '.label', 'like', '%' . $filters['label'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['phone']), function ($query) use ($filters) {
                $query->where($this->table . '.phone', 'like', '%' . $filters['phone'] . '%');
            })
            ->when(!empty($filters['user_id']), function ($query) use ($filters) {
                $query->where($this->table . '.user_id', '=', intval($filters['user_id']));
            });

        $query->with('owner');

        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the resource comment.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the resource class of the resource comment.
     *
     * @return BelongsTo
     */
    public function resourceClass(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }


    /**
     * Get the resource of the resource comment.
     *
     * @return object
     */
    public function resource(): object
    {
        return [];
        // @TODO
        //return $this->belongsTo(Resource::class, 'resource_id');
    }


    /**
     * Get the system user who owns the resource comment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'User_id');
    }
}
