<?php

namespace App\Models\System;

use App\Enums\EnvTypes;
use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class AdminDatabase extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'admin_databases';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'database_id',
        'name',
        'database',
        'tag',
        'title',
        'plural',
        'has_owner',
        'guest',
        'user',
        'admin',
        'menu',
        'menu_level',
        'menu_collapsed',
        'icon',
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
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'database_id', 'name', 'database', 'tag', 'title', 'plural',
        'has_owner', 'guest', 'user', 'admin', 'menu', 'menu_level', 'menu_collapsed', 'icon', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'sequence', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'admin|desc'         => 'admin',
        'database|asc'       => 'database',
        'database_id|asc'    => 'database id',
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'is_disabled|desc'   => 'disabled',
        'guest|desc'         => 'guest',
        'icon|asc'           => 'icon',
        'id|asc'             => 'id',
        'menu|desc'          => 'menu',
        'menu_level|asc'     => 'menu level',
        'name|asc'           => 'name',
        'owner_username|asc' => 'owner',
        'owner_id|asc'       => 'owner id',
        'plural|asc'         => 'plural',
        'is_public|asc'      => 'public',
        'sequence|asc'       => 'sequence',
        'tag|asc'            => 'tag',
        'title|asc'          => 'title',
        'user|desc'          => 'user',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'admin', 'database', 'is_disabled', 'guest', 'icon', 'menu', 'menu_level', 'name', 'is_public', 'sequence', 'tag', 'user', ],
        'guest' => [ 'admin', 'database', 'guest', 'icon', 'menu', 'menu_level', 'name', 'sequence', 'tag', 'user', ],
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

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['database']), function ($query) use ($filters) {
                $query->where($this->table . '.database', 'like', '%' . $filters['database'] . '%');
            })
            ->when(!empty($filters['database_id']), function ($query) use ($filters) {
                $query->where($this->table . '.database_id', '=', intval($filters['database_id']));
            })
            ->when(!empty($filters['has_owner']), function ($query) use ($filters) {
                $query->where($this->table . '.has_owner', '=', true);
            })
            ->when(!empty($filters['icon']), function ($query) use ($filters) {
                $query->where($this->table . '.icon', '=', ['icon']);
            })
            ->when(!empty($filters['menu']), function ($query) use ($filters) {
                $query->where($this->table . '.menu', '=', true);
            })
            ->when(!empty($filters['menu_collapsed']), function ($query) use ($filters) {
                $query->where($this->table . '.menu_collapsed', '=', true);
            })
            ->when(isset($filters['menu_level']), function ($query) use ($filters) {
                $query->where($this->table . '.menu_level', '=', intval(['menu_level']));
            })
            ->when(!empty($filters['plural']), function ($query) use ($filters) {
                $query->where($this->table . '.plural', 'like', '%' . $filters['plural'] . '%');
            })
            ->when(!empty($filters['tag']), function ($query) use ($filters) {
                $query->where($this->table . '.tag', 'like', '%' . $filters['tag'] . '%');
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['title'] . '%');
            });

        $query = $this->appendEnvironmentFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Get the system owner who owns the admin_databases.
     *
     * @returns BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Returns the admin_resource types.
     *
     * @param int|null $ownerId
     * @param string|null $dbName
     * @param array $filters
     * @param array $orderBy
     * @return array
     */
    public static function getResourceTypes(int|null    $ownerId,
                                            string|null $dbName = null,
                                            array       $filters = [],
                                            array       $orderBy = ['admin_resources.sequence', 'asc']):  array
    {
        if (empty($orderBy)) {
            $orderByColumn = 'admin_resources.sequence';
            $orderByDirection = 'asc';
        } else {
            $orderByColumn = is_array($orderBy) ? $orderBy[0] : 'admin_resources.sequence';
            $orderByDirection = is_array($orderBy) ? $orderBy[1] ?? 'asc'  : 'asc';
        }

        if (empty($ownerId)) {

            return Database::getResourceTypes($dbName, $filters);

        } else {

            $query = new AdminDatabase()->select(
                'admin_resources.*',
                'admin_databases.id as database_id',
                'admin_databases.name as database_name',
                'admin_databases.database as database_database',
                'admin_databases.tag as database_tag'
        )
                ->join('admin_resources', 'admin_resources.database_id', '=', 'admin_databases.id')
                ->orderBy($orderByColumn, $orderByDirection);

            if (!empty($dbName)) {
                $query->where('admin_databases.name', '=', $dbName);
            }

            if (isset($filters['is_public'])) {
                $query->where('admin_resources.is_public', '=', $filters['is_public'] ? 1 : 0);
            }

            if (isset($filters['is_readonly'])) {
                $query->where('admin_resources.is_readonly', '=', $filters['is_readonly'] ? 1 : 0);
            }

            if (isset($filters['is_root'])) {
                $query->where('admin_resources.is_root', '=', $filters['is_root'] ? 1 : 0);
            }

            if (isset($filters['is_disabled'])) {
                    $query->where('admin_resources.is_disabled', '=', $filters['is_disabled'] ? 1 : 0);
            }

            return $query->get()->toArray();
        }
    }

    /**
     * Returns the databases for specified owner.
     *
     * @param int|null $ownerId
     * @param EnvTypes|null $envType
     * @param array $filters
     * @param array $orderBy
     * @return Collection
     * @throws Exception
     */
    public static function ownerDatabases(int|null      $ownerId,
                                          EnvTypes|null $envType = EnvTypes::GUEST,
                                          array         $filters = [],
                                          array         $orderBy = [ 'sequence' => 'asc' ]): Collection
    {
        if (!empty($envType) && !in_array($envType, [ EnvTypes::ADMIN, EnvTypes::USER, EnvTypes::GUEST ])) {
            throw new Exception('ENV type ' . $envType->value . ' not supported');
        }

        $sortField = $orderBy[0] ?? 'sequence';
        $sortDir   = $orderBy[1] ?? 'asc';
        if (!str_starts_with($sortField, 'admin_databases.')) $sortField = 'admin_databases.'.$sortField;

        // create the query
        $query = new AdminDatabase()->orderBy($sortField, $sortDir);

        if (!empty($ownerId)) {
            $query->where('admin_databases.owner_id', '=', $ownerId);
        }

        // apply env type filter
        if (!empty($envType)) {
            $query->where('admin_databases.'.$envType->value, '=', 1);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {

            if (!str_starts_with($col, 'admin_databases.')) $col = 'admin_databases.'.$col;

            if (is_array($value)) {
                $query = $query->whereIn($col, $value);
            } else {
                $parts = explode(' ', $col);
                $col = $parts[0];
                if (!empty($parts[1])) {
                    $operator = trim($parts[1]);
                    if (in_array($operator, ['<>', '!=', '=!'])) {
                        $query->where($col, '<>', is_numeric($value) ? $value : str_replace("'", '', "'{$value}'"));
                    } elseif (strtolower($operator) == 'like') {
                        $query->whereLike($col, $value);
                    } else {
                        throw new Exception('Invalid admin_databases filter column: ' . $col . ' ' . $operator);
                    }
                } else {
                    $query = $query->where($col, '=', $value);
                }
            }
        }

        return $query->get();
    }

    /**
     * Get the system admin_resources of the admin_database.
     *
     * @return HasMany
     */
    public function resources(): HasMany
    {
        return $this->hasMany(AdminResource::class, 'database_id')
            ->where('owner_id', '=', $this->owner()->id)
            ->orderBy('name');
    }
}
