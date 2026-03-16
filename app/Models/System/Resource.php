<?php

namespace App\Models\System;

use App\Enums\EnvTypes;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Resource extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'owner_id',
        'database_id',
        'name',
        'table_name',
        'class',
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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'parent_id', 'owner_id', 'database_id', 'name', 'table_name', 'class', 'title',
        'plural', 'has_owner', 'guest', 'user', 'admin', 'menu', 'menu_level', 'menu_collapsed', 'icon', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        $query = new self()->getSearchQuery($filters, $owner)
            ->when(isset($filters['parent_id']), function ($query) use ($filters) {
                $query->where('parent_id', '=', intval($filters['parent_id']));
            })
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['database_id']), function ($query) use ($filters) {
                $query->where('database_id', '=', intval($filters['database_id']));
            })
            ->when(!empty($filters['table_name']), function ($query) use ($filters) {
                $query->where('table_name', 'like', '%' . $filters['table_name'] . '%');
            })
            ->when(!empty($filters['class']), function ($query) use ($filters) {
                $query->where('class', 'like', '%' . $filters['class'] . '%');
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(!empty($filters['plural']), function ($query) use ($filters) {
                $query->where('plural', 'like', '%' . $filters['plural'] . '%');
            })
            ->when(isset($filters['has_owner']), function ($query) use ($filters) {
                $query->where('has_owner', '=', boolval(['has_owner']));
            })
            ->when(isset($filters['menu']), function ($query) use ($filters) {
                $query->where('menu', '=', boolval(['menu']));
            })
            ->when(isset($filters['menu_level']), function ($query) use ($filters) {
                $query->where('menu_level', '=', intval(['menu_level']));
            })
            ->when(isset($filters['menu_collapsed']), function ($query) use ($filters) {
                $query->where('menu_collapsed', '=', boolval(['menu_collapsed']));
            })
            ->when(isset($filters['icon']), function ($query) use ($filters) {
                $query->where('icon', '=', ['icon']);
            });

        $query = $this->appendEnvironmentFilters($query, $filters);

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system owner of the resource.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the resource.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'parent_id');
    }

    /**
     * Get the children of the system resource.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Resource::class, 'parent_id');
    }

    /**
     * Get the system database that owns the resource.
     */
    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class, 'database_id');
    }

    /**
     * Returns the resources for specified owner.
     *
     * @param EnvTypes|null $envType
     * @param int|null $databaseId
     * @param array $filters
     * @param array|null $orderBy - if null then sorted by database.sequence and then resource.sequence
     * @return Collection
     * @throws Exception
     */
    public function ownerResources(EnvTypes|null $envType = EnvTypes::GUEST,
                                   int|null      $databaseId = null,
                                   array         $filters = [],
                                   array|null         $orderBy = null): Collection
    {
        $ownerId = 1;   // this is id of the primary root admin who owns all resources

        $sortField = $orderBy[0] ?? 'sequence';
        $sortDir   = $orderBy[1] ?? 'asc';
        if (!str_starts_with($sortField, 'resources.')) $sortField = 'resources.'.$sortField;

        // create the query
        $query = new Resource()->select([
            DB::raw("admins.name AS 'admin_name'"),
            DB::raw("admins.username AS 'admin_username'"),
            DB::raw("admins.label AS 'admin_label'"),
            DB::raw("databases.name AS 'database_name'"),
            DB::raw("databases.database AS 'database_database'"),
            DB::raw("databases.tag AS 'database_tag'"),
            'resources.*']
        )
        ->join('admins', 'admins.id', 'resources.owner_id')
        ->join('databases', 'databases.id', '=', 'resources.database_id')
        ->where('resources.'.$envType->value, '=', 1)
        ->where('resources.owner_id', '=', $ownerId)
        ->orderBy($sortField, $sortDir);

        // apply database filter
        if (!empty($databaseId)) {
            $query->where('resources.database_id', '=', $databaseId);
        }

        // apply envType
        if ($envType == EnvTypes::GUEST) {
            $query->where('resources.is_public', '=', true);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {

            if (!str_starts_with($col, 'admin_resources.')) $col = 'resources.'.$col;

            if (is_array($value)) {
                $query = $query->whereIn($col, $value);
            } else {
                $parts = explode(' ', $col);
                $col = $parts[0];

                if (!empty($parts[1])) {
                    $operator = trim($parts[1]);

                    if (in_array($operator, ['<>', '!=', '=!'])) {
                        $query->where($col, '<>', $value);
                    } elseif (strtolower($operator) == 'like') {
                        $query->whereLike($col, $value);
                    } else {
                        throw new Exception('Invalid resources filter column: ' . $col . ' ' . $operator);
                    }
                } else {

                    $query = $query->where($col, '=', $value);
                }
            }
        }

        $resources = $query->get();
        for ($i=0; $i<count($resources); $i++) {

            // add the route name to all the resources
            $routeName = 'admin.' . str_replace('_', '-', $resources[$i]->database_name)
                . '.' . $resources[$i]->name . '.index';
            $url = Route::has($routeName) ? route($routeName) : null;

            $resources[$i]->route = $routeName;
            $resources[$i]->url = $url;

            // add owner array to resource
            $resources[$i]->owner = [
                'id'       => $resources[$i]->owner_id,
                'name'     => $resources[$i]->admin_name,
                'username' => $resources[$i]->admin_username,
                'label'    => $resources[$i]->admin_label,
            ];
            unset($resources[$i]->admin_name);
            unset($resources[$i]->admin_username);
            unset($resources[$i]->admin_label);

            // add database array to resource
            $resources[$i]->database = [
                'id'       => $resources[$i]->database_id,
                'name'     => $resources[$i]->database_name,
                'database' => $resources[$i]->database_database,
                'tag'      => $resources[$i]->database_tag,
            ];
            unset($resources[$i]->database_name);
            unset($resources[$i]->database_database);
            unset($resources[$i]->database_tag);
        }

        return $resources;
    }

    /**
     * Get the system settings of the resource.
     *
     * @return HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(ResourceSetting::class, 'resource_id');
    }

    /**
     * Returns a resource from the database name and resource name.
     *
     * @param string $databaseName
     * @param string $resourceName
     * @return Resource|null
     */
    public function getResourceByName(string $databaseName, string $resourceName): ?Resource
    {
        return new self()->join('databases', 'databases.id', '=', 'resources.database_id')
            ->where('databases.name', '=', $databaseName)
            ->where('resources.name', '=', $resourceName)
            ->first(DB::Raw(implode(', ', [
                'databases.name as database_name',
                'databases.tag as database_tag',
                'databases.database as database_database',
                'databases.title as database_title',
                'databases.plural as database_plural',
                'resources.*'
            ])));
    }
}
