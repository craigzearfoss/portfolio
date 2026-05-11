<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Backup extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'backups';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'filepath',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'filepath', 'updated_at' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'updated_at', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'updated_at|asc' => 'datetime',
        'id|asc'         => 'id',
        'filepath|asc'   => 'filepath',
        'name|asc'       => 'name',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'id', 'name', 'filepath', 'updated_at' ],
        'guest' => [ 'id', 'name', 'filepath', 'updated_at' ],
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
     * @param string|null $sort
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
            ->when(!empty($filters['filepath']), function ($query) use ($filters) {
                $query->where($this->table . '.filepath', 'like', '%' . $filters['filepath'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            });

        // add timestamp filters
        $query = $this->appendTimestampFilters($query, $filters);

        $query->select([
            DB::raw('backups.*'),
        ] );

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }
}
