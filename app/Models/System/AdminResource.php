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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use JetBrains\PhpStorm\NoReturn;

/**
 *
 */
class AdminResource extends Model
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
    protected $table = 'admin_resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'owner_id',
        'resource_id',
        'database_id',
        'admin_database_id',
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
    const array SEARCH_COLUMNS = [ 'id', 'parent_id', 'owner_id', 'resource_id', 'database_id', 'admin_database_id',
        'name', 'table_name', 'class', 'title', 'plural', 'guest', 'user', 'admin', 'menu', 'menu_level',
        'menu_collapsed', 'icon', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'username', 'asc' ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [];
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
            ->when(!empty($filters['admin_database_id']), function ($query) use ($filters) {
                $query->where($this->table . '.admin_database_id', '=', intval($filters['admin_database_id']));
            })
            ->when(!empty($filters['class']), function ($query) use ($filters) {
                $query->where($this->table . '.class', 'like', '%' . $filters['class'] . '%');
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
            ->when(!empty($filters['menu_level']), function ($query) use ($filters) {
                $query->where($this->table . '.menu_level', '=', intval(['menu_level']));
            })
            ->when(!empty($filters['parent_id']), function ($query) use ($filters) {
                $query->where($this->table . '.parent_id', '=', intval($filters['parent_id']));
            })
            ->when(!empty($filters['plural']), function ($query) use ($filters) {
                $query->where($this->table . '.plural', 'like', '%' . $filters['plural'] . '%');
            })
            ->when(!empty($filters['resource_id']), function ($query) use ($filters) {
                $query->where($this->table . '.resource_id', '=', intval($filters['resource_id']));
            })
            ->when(!empty($filters['table_name']), function ($query) use ($filters) {
                $query->where($this->table . '.table_name', 'like', '%' . $filters['table_name'] . '%');
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['title'] . '%');
            });

        $query = $this->appendEnvironmentFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
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
     * Returns the admin resources for specified owner.
     *
     * @param Admin|Owner $owner
     * @param EnvTypes    $envType
     * @param string|null $databaseTag
     * @param array       $filters
     * @param array|null  $orderBy - if null then sorted by admin_databases.sequence and then admin_resources.sequence
     * @return Collection
     * @throws Exception
     */
    public function ownerResources(Admin|Owner $owner,
                                   EnvTypes    $envType = EnvTypes::GUEST,
                                   string|null $databaseTag = null,
                                   array       $filters = [],
                                   array|null  $orderBy = ['sequence', 'asc']): Collection
    {
        if (!in_array($envType, [ EnvTypes::ADMIN, EnvTypes::USER, EnvTypes::GUEST ])) {
            throw new Exception('ENV type ' . $envType->value . ' not supported');
        }

        // set sort order
        $sortField = $orderBy[0] ?? 'sequence';
        $sortDir   = $orderBy[1] ?? 'asc';
        if (!str_starts_with($sortField, 'admin_resources.')) $sortField = 'admin_resources.'.$sortField;

        // get column names for select
        $selectColumns = [];
        foreach (self::OWNER_PROPERTIES as $field => $name) {
            $selectColumns[] =  DB::raw("admins.$name AS '$field'");
        }
        foreach (self::DATABASE_PROPERTIES as $field => $name) {
            $selectColumns[] =  DB::raw("admin_databases.$name AS '$field'");
        }
        $selectColumns[] = 'admin_resources.*';

        // create the query
        $query = new AdminResource()->select($selectColumns)
        ->join('admins', 'admins.id', 'admin_resources.owner_id')
        ->join('admin_databases', 'admin_databases.id', 'admin_resources.admin_database_id')
        ->where('admin_resources.'.$envType->value, '=', true)
        ->where('admin_resources.owner_id', '=', $owner->id)
        ->orderBy($sortField, $sortDir);

        // apply database filter
        if (!empty($databaseTag)) {
            if (!$database = new Database()->firstWhere('tag', '=', $databaseTag)) {
                throw new Exception('Database tag ' . $databaseTag . ' not found');
            }
            $query->where('admin_resources.database_id', '=', $database['id']);
        }

        // apply envType
        if ($envType == EnvTypes::GUEST) {
            $query->where('admin_resources.is_public', '=', true)
                ->where('admin_resources.is_disabled', '=', false);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {

            if (!str_starts_with($col, 'admin_resources.')) $col = 'admin_resources.'.$col;

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
                        throw new Exception('Invalid admin_resources filter column: ' . $col . ' ' . $operator);
                    }
                } else {

                    $query = $query->where($col, '=', $value);
                }
            }
        }
//$query->ddRawSql();
        // add "route", "active", "owner", and "database" fields to all the resources
        $adminResources = $query->get();

        for ($i=0; $i<count($adminResources); $i++) {
            $this->appendRouteFieldToResource($adminResources[$i], $envType, $owner);
            $this->appendOwnerFieldToResource($adminResources[$i], $envType, $owner);
            $this->appendDatabaseFieldToResource($adminResources[$i], $envType, $owner);
        }

        return $adminResources;
    }

    /**
     * Returns the admin resources for the specified owner by admin database.
     *
     * @param Admin|Owner|null $owner
     * @param EnvTypes         $envType
     * @param string|null      $databaseTag
     * @param array            $filters
     * @param array|null       $orderBy - if null then sorted by databases sequence and then resources sequence
     * @return array
     * @throws Exception
     */
    public function ownerResourcesByDatabase(Admin|Owner|null $owner,
                                             EnvTypes         $envType = EnvTypes::GUEST,
                                             string|null      $databaseTag = null,
                                             array            $filters = [],
                                             array|null       $orderBy = null): array
    {
        if (empty($owner)) {
            return [];
        }

        $adminResources = $this->ownerResources($owner, $envType, $databaseTag, $filters, $orderBy);

        $adminDatabaseIds = [];
        $adminDatabases = [];
        $adminResourcesByAdminDatabaseId = [];

        foreach ($adminResources as $adminResource) {

            if (!in_array($adminResource->admin_database_id, $adminDatabaseIds)) {

                $adminDatabaseIds[] = $adminResource->admin_database_id;

                $adminDatabase = new AdminDatabase()->find($adminResource->admin_database_id);
                $this->appendRouteFieldToDatabase($adminDatabase, $envType, $owner);
                $adminDatabase->owner = $owner;
                $adminDatabases[] = $adminDatabase;
                $adminResourcesByAdminDatabaseId[$adminResource->admin_database_id] = [];
            }
            $adminResourcesByAdminDatabaseId[$adminResource->admin_database_id][] = $adminResource;
        }

        foreach ($adminDatabases as $adminDatabase) {
            $adminDatabase->resources = Collection::make($adminResourcesByAdminDatabaseId[$adminDatabase['id']]);
        }

        // add dictionary item
        $adminDatabases[] = new  Database()->getDictionaryDatabase();

        return $adminDatabases;
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
     * Returns an admin resource for an owner from the database name and resource name.
     *
     * @param Admin|Owner $owner
     * @param string $databaseName
     * @param string $resourceName
     * @return AdminResource|null
     */
    #[NoReturn] public function getResourceByName(Admin|Owner $owner, string $databaseName, string $resourceName): ?AdminResource
    {

        // get column names for select
        $selectColumns = [
            DB::raw("admins.name AS 'admin_name'"),
            DB::raw("admins.username AS 'admin_username'"),
            DB::raw("admins.label AS 'admin_label'"),
        ];
        foreach (self::DATABASE_PROPERTIES as $field => $name) {
            $selectColumns[] =  DB::raw("admin_databases.$name AS '$field'");
        }
        $selectColumns[] = 'admin_resources.*';

        $adminResource = new self()->join('admin_databases', 'admin_databases.id', '=', 'admin_resources.admin_database_id')
            ->where('admin_databases.owner_id', '=', $owner->id)
            ->where('admin_databases.name', '=', $databaseName)
            ->where('admin_resources.name', '=', $resourceName)
            ->first(DB::Raw(implode(', ', [
                'admin_databases.name as database_name',
                'admin_databases.database as database_database',
                'admin_databases.tag as database_tag',
                'admin_databases.title as database_title',
                'admin_databases.plural as database_plural',
                'admin_databases.has_owner as database_has_owner',
                'admin_databases.guest as database_guest',
                'admin_databases.user as database_user',
                'admin_databases.admin as database_admin',
                'admin_databases.menu as database_menu',
                'admin_databases.menu_level as database_menu_level',
                'admin_databases.menu_collapsed as database_menu_collapsed',
                'admin_databases.plural as database_plural',

                'admin_databases.icon as database_icon',
                'admin_databases.is_public as database_is_public',
                'admin_databases.is_readonly as database_is_readonly',
                'admin_databases.is_root as database_is_root',
                'admin_databases.is_disabled as database_is_disabled',
                'admin_databases.is_demo as database_is_demo',
                'admin_databases.sequence as database_sequence',
                'admin_resources.*'
            ])));

        $this->appendRouteFieldToResource($adminResource);
        $this->appendOwnerFieldToResource($adminResource);
        $this->appendDatabaseFieldToResource($adminResource);
    }

    /**
     * Add the "route" and "active" fields to an admin resource from a query result.
     *
     * @param AdminDatabase    $adminDatabase
     * @param EnvTypes|null    $envType
     * @param Admin|Owner|null $owner
     * @return void
     */
    protected function appendRouteFieldToDatabase(
        AdminDatabase    $adminDatabase,
        EnvTypes|null    $envType = EnvTypes::GUEST,
        Admin|Owner|null $owner = null): void
    {
        $url = null;

        $routeName = $envType->value . '.' . str_replace('_', '-', $adminDatabase->name) . '.index';

        if (Route::has($routeName)) {
            if ($envType == EnvTypes::GUEST) {
                $url = route($routeName, $owner);
            } else {
                $url = route($routeName);
            }
        }

        $adminDatabase->route = $routeName;
        $adminDatabase->url = $url;
        $adminDatabase->active = getRouteBase(($routeName)) === getRouteBase(Route::currentRouteName());
    }

    /**
     * Add the "route", "url", and "active" properties to an admin resource from a query result.
     *
     * @param AdminResource $adminResource
     * @param EnvTypes|null $envType
     * @param Admin|Owner|null $owner
     * @return void
     */
    protected function appendRouteFieldToResource(
        AdminResource    $adminResource,
        EnvTypes|null    $envType = EnvTypes::GUEST,
        Admin|Owner|null $owner = null): void
    {
        $url = null;

        $routeName = $envType->value
            . '.' . str_replace('_', '-', $adminResource->database_name)
            . '.' . $adminResource->name
            . '.index';

        if (Route::has($routeName)) {
            if ($envType == EnvTypes::GUEST) {
                $url = route($routeName, $owner);
            } else {
                $url = route($routeName);
            }
        }

        $adminResource->route = $routeName;
        $adminResource->url = $url;
        $adminResource->active = getRouteBase(($routeName)) === getRouteBase(Route::currentRouteName());
    }

    /**
     * Add the "owner" property to an admin resource from a query result.
     *
     * @param AdminResource $adminResource
     * @param EnvTypes|null    $envType
     * @param Admin|Owner|null $owner
     * @return void
     */
    protected function appendOwnerFieldToResource(
        AdminResource    &$adminResource,
        EnvTypes|null    $envType = EnvTypes::GUEST,
        Admin|Owner|null $owner = null): void
    {
        if (empty($owner)) {

            $owner = new Admin();

            foreach (self::OWNER_PROPERTIES as $field => $name) {
                $owner->$name = $adminResource[$field] ?? null;
                unset($adminResource[$field]);
            }
        }

        foreach (self::OWNER_PROPERTIES as $field => $name) {
            unset($adminResource[$field]);
        }

        $adminResource->owner = $owner;
    }

    /**
     * Add the "database" property to an admin resource from a query result.
     *
     * @param AdminResource $adminResource
     * @param EnvTypes|null $envType
     * @param Admin|Owner|null $owner
     * @return void
     */
    #[NoReturn] protected function appendDatabaseFieldToResource(
        AdminResource    &$adminResource,
        EnvTypes|null    $envType = EnvTypes::GUEST,
        Admin|Owner|null $owner = null): void
    {
        $adminDatabase = new AdminDatabase();

        foreach (self::DATABASE_PROPERTIES as $field => $name) {
            $adminDatabase->$name = $adminResource[$field] ?? null;
            if ($field !== 'database_id') {
                unset($adminResource[$field]);
            }
        }

        $this->appendRouteFieldToDatabase($adminDatabase, $envType, $owner);
        $adminDatabase->owner = $owner;

        $adminResource->database = $adminDatabase;
    }
}
