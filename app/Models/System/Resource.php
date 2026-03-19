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
use JetBrains\PhpStorm\NoReturn;

/**
 *
 */
class Resource extends Model
{
    use SearchableModelTrait, SoftDeletes;

    const array OWNER_PROPERTIES = [
        'admin_id'                   => 'id',
        'admin_username'             => 'username',
        'admin_name'                 => 'name',
        'admin_label'                => 'label',
        'admin_salutation'           => 'salutation',
        'admin_title'                => 'title',
        'admin_role'                 => 'role',
        'admin-employer'             => 'employer',
        'admin_employment_status_id' => 'employment_status_id',
        'admin_street'               => 'street',
        'admin_street2'              => 'street2',
        'admin_city'                 => 'city',
        'admin_state_id'             => 'state_id',
        'admin_zip'                  => 'zip',
        'admin_country_id'           => 'country_id',
        'admin_latitude'             => 'latitude',
        'admin_longitude'            => 'longitude',
        'admin_phone'                => 'phone',
        'admin_email'                => 'email',
        'admin_email_verified_at'    => 'email_verified_at',
        'admin_birthday'             => 'birthday',
        'admin_bio'                  => 'bio',
        'admin_notes'                => 'notes',
        'admin_link'                 => 'link',
        'admin_link_name'            => 'link_name',
        'admin_description'          => 'description',
        'admin_disclaimer'           => 'disclaimer',
        'admin_image'                => 'image',
        'admin_image_credit'         => 'image_credit',
        'admin_image_source'         => 'image_source',
        'admin_thumbnail'            => 'thumbnail',
        'admin_logo'                 => 'logo',
        'admin_logo_small'           => 'logo_small',
        'admin_requires_relogin'     => 'requires_relogin',
        'admin_is_public'            => 'is_public',
        'admin_is_readonly'          => 'is_readonly',
        'admin_is_root'              => 'is_root',
        'admin_is_disabled'          => 'is_disabled',
        'admin_is_demo'              => 'is_demo',
        'admin_sequence'             => 'sequence',
        'admin_created_at'           => 'created_at',
        'admin_updated_at'           => 'updated_at',
        'admin_admin_team_id'        => 'admin_team_id',
    ];

    const array DATABASE_PROPERTIES = [
        'database_id'             => 'id',
        'database_name'           => 'name',
        'database_database'       => 'database',
        'database_tag'            => 'tag',
        'database_title'          => 'title',
        'database_plural'         => 'plural',
        'database_has_owner'      => 'has_owner',
        'database_guest'          => 'guest',
        'database_user'           => 'user',
        'database_admin'          => 'admin',
        'database_menu'           => 'menu',
        'database_menu_level'     => 'menu_level',
        'database_menu_collapsed' => 'menu_collapsed',
        'database_icon'           => 'icon',
        'database_is_public'      => 'is_public',
        'database_is_readonly'    => 'is_readonly',
        'database_is_root'        => 'is_root',
        'database_is_disabled'    => 'is_disabled',
        'database_is_demo'        => 'is_demo',
        'database_sequence'       => 'sequence',
        'database_created_at'     => 'created_at',
        'database_updated_at'     => 'updated_at',
    ];

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
     * Returns all the resources.
     *
     * @param EnvTypes    $envType
     * @param string|null $databaseTag
     * @param array       $filters
     * @param array|null  $orderBy - if null then sorted by databases.sequence and then resources.sequence
     * @return Collection
     * @throws Exception
     */
    public function ownerResources(EnvTypes    $envType = EnvTypes::GUEST,
                                   string|null $databaseTag = null,
                                   array       $filters = [],
                                   array|null  $orderBy =  ['sequence', 'asc']): Collection
    {
        // the owner is the root admin who can view all resources
        $owner = new Admin()->find(1);

        if (!in_array($envType, [ EnvTypes::ADMIN, EnvTypes::USER, EnvTypes::GUEST ])) {
            throw new Exception('ENV type ' . $envType->value . ' not supported');
        }

        // set sort order
        $sortField = $orderBy[0] ?? 'sequence';
        $sortDir   = $orderBy[1] ?? 'asc';
        if (!str_starts_with($sortField, 'resources.')) $sortField = 'resources.'.$sortField;

        // get column names for select
        $selectColumns = [];
        foreach (self::OWNER_PROPERTIES as $field => $name) {
            $selectColumns[] =  DB::raw("admins.$name AS '$field'");
        }
        foreach (self::DATABASE_PROPERTIES as $field => $name) {
            $selectColumns[] =  DB::raw("databases.$name AS '$field'");
        }
        $selectColumns[] = 'resources.*';

        // create the query
        $query = new Resource()->select($selectColumns)
        ->join('admins', 'admins.id', 'resources.owner_id')
        ->join('databases', 'databases.id', '=', 'resources.database_id')
        ->where('resources.'.$envType->value, '=', true)
        ->orderBy($sortField, $sortDir);

        // apply database filter
        if (!empty($databaseTag)) {
            if (!$database = new Database()->firstWhere('tag', '=', $databaseTag)) {
                throw new \Exception('Database tag ' . $databaseTag . ' not found');
            }
            $query->where('resources.database_id', '=', $database['id']);
        }

        // apply envType
        if ($envType == EnvTypes::GUEST) {
            $query->where('resources.is_public', '=', true)
                ->where('resources.is_disabled', '=', false);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {

            if (!str_starts_with($col, 'resources.')) $col = 'resources.'.$col;

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

        // add "route", "active", "owner", and "database" fields to all the resources
        $resources = $query->get();

        for ($i=0; $i<count($resources); $i++) {
            $this->appendRouteFieldToResource($resources[$i], $envType, $owner);
            $this->appendOwnerFieldToResource($resources[$i], $envType, $owner);
            $this->appendDatabaseFieldToResource($resources[$i], $envType, $owner);
        }

        return $resources;
    }

    /**
     * Returns the resources by database.
     *
     * @param EnvTypes    $envType
     * @param string|null $databaseTag
     * @param array       $filters
     * @param array|null  $orderBy - if null then sorted by database.sequence and then resource.sequence
     * @return array
     * @throws Exception
     */
    public function ownerResourcesByDatabase(EnvTypes    $envType = EnvTypes::GUEST,
                                             string|null $databaseTag = null,
                                             array       $filters = [],
                                             array|null  $orderBy = null): array
    {
        $resources = $this->ownerResources($envType, $databaseTag, $filters, $orderBy);

        $databaseIds = [];
        $databases = [];
        $resourcesByDatabaseId = [];

        foreach ($resources as $resource) {

            if (!in_array($resource->admin_database_id, $databaseIds)) {

                $databaseIds[] = $resource->admin_database_id;

                $database = new Database()->find($resource->database_id);
                $this->appendRouteFieldToDatabase($database, $envType);

                $databases[] = $database;
                $resourcesByDatabaseId[$resource->database_id] = [];
            }
            $resourcesByDatabaseId[$resource->database_id][] = $resource;
        }

        foreach ($databases as $database) {
            $database->resources = Collection::make($resourcesByDatabaseId[$database->id]);
        }

        return $databases;
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

    /**
     * Add the "route" and "active" fields to a resource from a query result.
     *
     * @param Database $database
     * @param EnvTypes|null $envType
     * @return void
     */
    protected function appendRouteFieldToDatabase(
        Database      &$database,
        EnvTypes|null $envType = EnvTypes::GUEST): void
    {
        $url = null;

        $routeName = $envType->value . '.' . str_replace('_', '-', $database->name) . '.index';

        if (Route::has($routeName)) {
            $url = route($routeName);
        }

        $database->route = $routeName;
        $database->url = $url;
        $database->active = getRouteBase(($routeName)) === getRouteBase(Route::currentRouteName());
    }

    /**
     * Add the "route", "url", and "active" properties to a resource from a query result.
     *
     * @param Resource $resource
     * @param EnvTypes|null $envType
     * @return void
     */
    protected function appendRouteFieldToResource(
        Resource         &$resource,
        EnvTypes|null    $envType = EnvTypes::GUEST): void
    {
        $url = null;

        $routeName = $envType->value
            . '.' . str_replace('_', '-', $resource->database_name)
            . '.' . $resource->name
            . '.index';

        if (Route::has($routeName)) {
            $url = Route::has($routeName) ? route($routeName) : null;
        }

        $resource->route = $routeName;
        $resource->url = $url;
        $resource->active = getRouteBase(($routeName)) === getRouteBase(Route::currentRouteName());
    }

    /**
     * Add the "owner" property to a resource from a query result.
     *
     * @param Resource $resource
     * @param EnvTypes|null    $envType
     * @param Admin|Owner|null $owner
     * @return void
     */
    protected function appendOwnerFieldToResource(
        Resource         &$resource,
        EnvTypes|null    $envType = EnvTypes::GUEST,
        Admin|Owner|null $owner = null): void
    {
        if (empty($owner)) {

            $owner = new Admin();

            foreach (self::OWNER_PROPERTIES as $field => $name) {
                $owner->$name = $resource[$field] ?? null;
                unset($resource[$field]);
            }
        }

        $resource->owner = $owner;
    }

    /**
     * Add the "database" property to a resource from a query result.
     *
     * @param Resource $resource
     * @param EnvTypes|null $envType
     * @param Admin|Owner|null $owner
     * @return void
     */
    #[NoReturn] protected function appendDatabaseFieldToResource(
        Resource         &$resource,
        EnvTypes|null    $envType = EnvTypes::GUEST,
        Admin|Owner|null $owner = null): void
    {
        $database = new Database();

        foreach (self::DATABASE_PROPERTIES as $field => $name) {
            $database->$name = $resource[$field] ?? null;
            if ($field !== 'database_id') {
                unset($resource[$field]);
            }
        }

        $this->appendRouteFieldToDatabase($database, $envType);
        $database->owner = $owner;

        $resource->database = $database;
    }
}
