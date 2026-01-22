<?php

namespace App\Models\System;

use App\Models\System\ResourceSetting;
use App\Services\PermissionService;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        'global',   // the resource has no owner
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'database_id', 'name', 'parent_id', 'table', 'title', 'plural', 'guest',
        'user', 'admin', 'global', 'menu', 'menu_level', 'menu_collapsed', 'icon', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

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
     * @param string|null $envType
     * @param int|null $databaseId
     * @param array $filters
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public static function ownerResources(int|null    $ownerId,
                                          string|null $envType = PermissionService::ENV_GUEST,
                                          int|null    $databaseId = null,
                                          array       $filters = [],
                                          array       $orderBy = [ 'sequence' => 'asc' ]): Collection
    {
        if ($envType == 'root') $envType = PermissionService::ENV_ADMIN;
        if (!empty($envType) && !in_array($envType, PermissionService::ENV_TYPES)) {
            throw new \Exception('ENV type ' . $envType . ' not supported');
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
            $query->where('resources.'.$envType, 1);
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
                    $operation = trim($parts[1]);
                    if (in_array($operation, ['<>', '!=', '=!'])) {
                        $query->where($col, $operation, $value);
                    } elseif (strtolower($operation) == 'like') {
                        $query->whereLike($col, $value);
                    } else {
                        throw new \Exception('Invalid resources filter column: ' . $col . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($col, $value);
                }
            }
        }

        return $query->get();
    }

    /**
     * Returns the resources.
     *
     * @param string|null $envType
     * @param int|null $databaseId
     * @param array $filters
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public static function ownerResources___OLD(string|null $envType,
                                          int|null    $databaseId = null,
                                          array       $filters = [],
                                          array       $orderBy = [ 'sequence' => 'asc' ]): Collection
    {
        if (!empty($envType) && !in_array($envType, PermissionService::ENV_TYPES)) {
            throw new \Exception('ENV type ' . $envType . ' not supported');
        }

        $query = AdminResource::orderBy($orderBy[0] ?? 'sequence', $orderBy[1] ?? 'asc');

        // apply env type filter
        if (!empty($databaseId)) {
            $query->where($envType, 1);
        }

        // apply database filter
        if (!empty($databaseId)) {
            $query->where('database_id', $databaseId);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($col, $value);
            } else {
                $parts = explode(' ', $col);
                $col = $parts[0];
                if (!empty($parts[1])) {
                    $operation = trim($parts[1]);
                    if (in_array($operation, ['<>', '!=', '=!'])) {
                        $query->where($col, $operation, $value);
                    } elseif (strtolower($operation) == 'like') {
                        $query->whereLike($col, $value);
                    } else {
                        throw new \Exception('Invalid resource filter column: ' . $col . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($col, $value);
                }
            }
        }


        return $query->get();
    }
}
