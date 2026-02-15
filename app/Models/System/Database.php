<?php

namespace App\Models\System;

use App\Enums\EnvTypes;
use App\Services\PermissionService;
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

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Database extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'system_db';

    protected $table = 'databases';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'database',
        'tag',
        'title',
        'plural',
        'has_owner',
        'guest',
        'user',
        'admin',
        'global',   // the database has no owner
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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'database', 'tag', 'title', 'plural', 'guest', 'user', 'admin',
        'global', 'menu', 'menu_level', 'menu_collapsed', 'icon', 'public', 'readonly', 'root', 'disabled', 'demo'];
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
            ->when(!empty($filters['database']), function ($query) use ($filters) {
                $query->where('database', 'like', '%' . $filters['database'] . '%');
            })
            ->when(!empty($filters['tag']), function ($query) use ($filters) {
                $query->where('tag', 'like', '%' . $filters['tag'] . '%');
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
     * Get the system owner who owns the database.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the system resources of the database.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class, 'database_id')
            ->orderBy('name');
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
        //????????if ($envType == 'root') $envType = EnvTypes::ADMIN;
        if (!empty($envType) && !in_array($envType, [ EnvTypes::ADMIN, EnvTypes::USER, EnvTypes::GUEST ])) {
            throw new Exception('ENV type ' . $envType->value . ' not supported');
        }

        $sortField = $orderBy[0] ?? 'sequence';
        $sortDir   = $orderBy[1] ?? 'asc';
        if (substr($sortField, 0, 16) !== 'databases.') $sortField = 'databases.'.$sortField;

        // create the query
        $query = new Database()->orderBy($sortField, $sortDir);

        if (!empty($ownerId)) {
            $query->where('databases.owner_id', $ownerId);
        }

        // apply env type filter
        if (!empty($envType)) {
            $query->where('databases.'.$envType->value, 1);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {

            if (substr($col, 0, 16) !== 'databases.') $col = 'databases.'.$col;

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
                        throw new Exception('Invalid databases filter column: ' . $col . ' ' . $operator);
                    }
                } else {
                    $query = $query->where($col, $value);
                }
            }
        }

        return $query->get();
    }

    /**
     * Returns the resource types.
     *
     * @param string|null $dbName
     * @param array $filters
     * @param array $orderBy
     * @return array
     */
    public static function getResourceTypes(string|null $dbName = null,
                                            array       $filters = [],
                                            array       $orderBy = ['seq', 'asc']):  array
    {
        $query = new Database()->select( 'resources.*', 'databases.id as database_id', 'databases.name as database_name'
                , 'databases.database as database_database'
            )
            ->join('resources', 'resources.database_id', '=', 'databases.id')
            ->orderBy('resources.sequence');

        if(!empty($dbName)) {
            $query->where('databases.name', $dbName);
        }

        if (isset($filters['public'])) $query->where('resources.public', $filters['public'] ? 1 : 0);
        if (isset($filters['readonly'])) $query->where('resources.readonly', $filters['readonly'] ? 1 : 0);
        if (isset($filters['root'])) $query->where('resources.root', $filters['root'] ? 1 : 0);
        if (isset($filters['disabled'])) $query->where('resources.disabled', $filters['disabled'] ? 1 : 0);

        return $query->get()->toArray();
    }
}
