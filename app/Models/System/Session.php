<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Session extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'user_id', 'admin_id', 'ip_address', 'user_agent', 'payload',
        'last_activity' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'last_activity', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'admin_id|asc'       => 'admin id',
        'ip_address|asc'     => 'ip address',
        'id|asc'             => 'id',
        'last_activity|desc' => 'last activity',
        'user_id|asc'        => 'user id',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'admin_id', 'ip_address', 'id', 'last_activity', 'user_id' ],
        'guest' => [ 'admin_id', 'ip_address', 'id', 'last_activity', 'user_id' ],
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

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['admin_id']);
            }
            $filters['admin_id'] = $owner->id;
        }

        return new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['admin_id']), function ($query) use ($filters) {
                $query->where($this->table . '.admin_id', '=', intval($filters['admin_id']));
            })
            ->when(!empty($filters['ip_address']), function ($query) use ($filters) {
                $query->where($this->table . '.ip_address', '=', $filters['ip_address']);
            })
            ->when(!empty($filters['user_id']), function ($query) use ($filters) {
                $query->where($this->table . '.user_id', '=', intval($filters['user_id']));
            });
    }
}
