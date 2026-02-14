<?php

namespace App\Models\System;

use App\Enums\EnvTypes;
use App\Models\System\ResourceSetting;
use App\Services\PermissionService;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Resource extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'system_db';

    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'database_id',
        'name',
        'parent_id',
        'table',
        'class',
        'title',
        'plural',
        'has_owner',
        'guest',
        'user',
        'admin',
        'global',
        'menu',
        'menu_level',
        'menu_collapsed',
        'icon',
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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'database_id', 'name', 'parent_id', 'table', 'title', 'plural', 'guest',
        'user', 'admin', 'global', 'menu', 'menu_level', 'menu_collapsed', 'icon', 'public', 'readonly', 'root', 'disabled', 'demo'];
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
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        return self::getSearchQuery($filters)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['database_id']), function ($query) use ($filters) {
                $query->where('database_id', '=', intval($filters['database_id']));
            })
            ->when(isset($filters['parent_id']), function ($query) use ($filters) {
                $query->where('parent_id', '=', intval($filters['parent_id']));
            })
            ->when(!empty($filters['table']), function ($query) use ($filters) {
                $query->where('table', 'like', '%' . $filters['table'] . '%');
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
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
    }

    /**
     * Get the system owner of the resource.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the system database that owns the resource.
     */
    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class, 'database_id');
    }

    /**
     * Get the parent of the resource.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'parent_id');
    }

    /**
     * Get the children of the system resource.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Resource::class, 'parent_id');
    }

    /**
     * Get the system settings of the resource.
     */
    public function settings(): HasMany
    {
        return $this->hasMany(ResourceSetting::class, 'resource_id');
    }

    /**
     * Returns the resources for specified owner.
     *
     * @param int|null $ownerId
     * @param EnvTypes|null $envType
     * @param int|null $databaseId
     * @param array $filters
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public static function ownerResources(int|null      $ownerId,
                                          EnvTypes|null $envType = EnvTypes::GUEST,
                                          int|null      $databaseId = null,
                                          array         $filters = [],
                                          array         $orderBy = [ 'sequence' => 'asc' ]): Collection
    {
        //?????????if ($envType == 'root') $envType = EnvTypes::ADMIN;
        if (!empty($envType) && !in_array($envType, [ EnvTypes::ADMIN, EnvTypes::USER, EnvTypes::GUEST ])) {
            throw new \Exception('ENV type ' . $envType->value . ' not supported');
        }

        $sortField = $orderBy[0] ?? 'sequence';
        $sortDir   = $orderBy[1] ?? 'asc';
        if (substr($sortField, 0, 10) !== 'resources.') $sortField = 'resources.'.$sortField;

        // create the query
        $query = Resource::select([DB::raw("databases.name AS 'database_name'"), 'resources.*'])
            ->join('databases', 'databases.id', 'resources.database_id')
            ->orderBy($sortField, $sortDir);

        if (!empty($ownerId)) {
            $query->where('resources.owner_id', $ownerId);
        }

        // apply env type filter
        if (!empty($envType)) {
            $query->where('resources.'.$envType->value, 1);
        }

        // apply database filter
        if (!empty($databaseId)) {
            $query->where('resources.database_id', $databaseId);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {

            if (substr($col, 0, 16) !== 'resources.') $col = 'resources.'.$col;

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
                        throw new \Exception('Invalid resources filter column: ' . $col . ' ' . $operator);
                    }
                } else {
                    $query = $query->where($col, $value);
                }
            }
        }

        return $query->get();
    }
}
