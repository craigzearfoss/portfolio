<?php

namespace App\Models\System;

use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Services\PermissionService;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class AdminDatabase extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'system_db';

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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'database_id', 'name', 'database', 'tag', 'title', 'plural', 'guest',
        'user', 'admin', 'global', 'menu', 'menu_level', 'menu_collapsed', 'icon', 'public', 'readonly', 'root',
        'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the system owner who owns the admin_databases.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the system admin_resources of the admin_databases.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(AdminResource::class, 'database_id')
            ->where('owner_id', $this->owner()->id)->orderBy('name', 'asc');
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
                                            array       $orderBy = ['sequence', 'asc']):  array
    {
        if (empty($ownerId)) {

            return Database::getResourceTypes($ownerId, $dbName, $filters);

        } else {

            $query = AdminDatabase::select('admin_resources.*', 'admin_databases.id as database_id',
                'admin_databases.name as database_name', 'admin_databases.database as database_database'
            )
                ->join('admin_resources', 'admin_resources.database_id', '=', 'admin_databases.id')
                ->orderBy('admin_resources.sequence', 'asc');

            if (!empty($dbName)) {
                $query->where('admin_databases.name', $dbName);
            }

            if (isset($filters['public'])) $query->where('admin_resources.public', boolval($filters['public']) ? 1 : 0);
            if (isset($filters['readonly'])) $query->where('admin_resources.readonly', boolval($filters['readonly']) ? 1 : 0);
            if (isset($filters['root'])) $query->where('admin_resources.root', boolval($filters['root']) ? 1 : 0);
            if (isset($filters['disabled'])) $query->where('admin_resources.disabled', boolval($filters['disabled']) ? 1 : 0);

            return $query->get()->toArray();
        }
    }

    /**
     * Returns the admin_resource types.
     *
     * @param int $ownerId
     * @param string|null $dbName
     * @param array $filters
     * @param array $orderBy
     * @return array
     */
    public static function getResourceTypes_OLD(int         $ownerId,
                                            string|null $dbName = null,
                                            array       $filters = [],
                                            array       $orderBy = ['seq', 'asc']):  array
    {
        $query = Database::select( 'admin_resources.*', 'databases.id as database_id', 'databases.name as database_name'
            , 'databases.database as database_database'
        )
            ->join('admin_resources', 'admin_resources.database_id', '=', 'admin_databases.id')
            ->where('admin_databases.owner_id', $ownerId)
            ->where('admin_resources.owner_id', $ownerId)
            ->orderBy('admin_resources.sequence', 'asc');

        if(!empty($dbName)) {
            $query->where('admin_databases.name', $dbName);
        }

        if (isset($filters['public'])) $query->where('admin_resources.public', boolval($filters['public']) ? 1 : 0);
        if (isset($filters['readonly'])) $query->where('admin_resources.readonly', boolval($filters['readonly']) ? 1 : 0);
        if (isset($filters['root'])) $query->where('admin_resources.root', boolval($filters['root']) ? 1 : 0);
        if (isset($filters['disabled'])) $query->where('admin_resources.disabled', boolval($filters['disabled']) ? 1 : 0);

        return $query->get()->toArray();
    }
}
