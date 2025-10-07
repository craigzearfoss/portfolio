<?php

namespace App\Models;

use App\Http\Requests\ResourceStoreRequest;
use App\Models\Database;
use App\Models\Owner;
use App\Services\PermissionService;
use App\Traits\SearchableModelTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Resource extends Model
{
    use SearchableModelTrait;

    protected $connection = 'core_db';

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
        'title',
        'plural',
        'guest',
        'user',
        'admin',
        'icon',
        'level',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'database_id', 'name', 'parent_id', 'table', 'title', 'plural', 'guest',
        'user', 'admin', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the owner of the resource.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the database that owns the resource.
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
     * Get the children of the resource.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Resource::class, 'parent_id');
    }

    /**
     * Returns the resources for the ENV type sorted by database and resource sequence.
     *
     * @param string | null $database
     * @param string | null $envType
     * @param array $filters
     * @return Collection
     * @throws \Exception
     */
    public static function bySequence(string | null $database,
                                      string | null $envType,
                                      array $filters = []): Collection
    {
        if (!in_array($envType, PermissionService::ENV_TYPES)) {
            throw new \Exception('ENV type ' . $envType . ' not supported');
        }

        $query = Resource::select(
                [
                    'databases.database as database',
                    DB::raw('databases.id as db_id'),
                    DB::raw('databases.name as db_name'),
                    DB::raw('databases.database as db_database'),
                    DB::raw('databases.tag as db_tag'),
                    DB::raw('databases.title as db_title'),
                    DB::raw('databases.plural as db_plural'),
                    DB::raw('databases.guest as db_guest'),
                    DB::raw('databases.user as db_user'),
                    DB::raw('databases.admin as db_admin'),
                    DB::raw('databases.icon as db_icon'),
                    DB::raw('databases.sequence as db_sequence'),
                    DB::raw('databases.public as db_public'),
                    DB::raw('databases.readonly as db_readonly'),
                    DB::raw('databases.root as db_root'),
                    DB::raw('databases.disabled as db_disabled'),
                    DB::raw('databases.owner_id as db_owner_id'),
                    'resources.*'
                ]
            )
            ->join('databases', 'databases.id', 'resources.database_id')
            ->orderBy('databases.sequence', 'asc')
            ->orderBy('resources.sequence', 'asc');

        if (!empty($database)) {
            $query->where('databases.name', $database);
        }

        if (!empty($envType)) {
            $query->where('databases.'.$envType, 1)
                ->where('resources.'.$envType, 1);
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
                        throw new \Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($col, $value);
                }
            }
        }

        $resources = $query->get();
        for ($i=0; $i<count($resources); $i++) {
            $resources[$i]->database = [
                'id'       => $resources[$i]->db_id,
                'name'     => $resources[$i]->db_name,
                'database' => $resources[$i]->db_database,
                'tag'      => $resources[$i]->db_tag,
                'title'    => $resources[$i]->db_title,
                'plural'   => $resources[$i]->db_plural,
                'guest'    => $resources[$i]->db_guest,
                'user'     => $resources[$i]->db_user,
                'admin'    => $resources[$i]->db_admin,
                'icon'     => $resources[$i]->db_icon,
                'sequence' => $resources[$i]->db_sequence,
                'public'   => $resources[$i]->db_public,
                'readonly' => $resources[$i]->db_read_only,
                'root'     => $resources[$i]->db_root,
                'disabled' => $resources[$i]->db_disabled,
                'owner_id' => $resources[$i]->db_owner_id,
            ];
            foreach (['db_id', 'db_name', 'db_database', 'db_tag', 'db_title', 'db_plural', 'db_guest', 'db_user',
                         'db_admin', 'db_icon', 'db_sequence', 'db_public', 'db_readonly', 'db_root', 'db_disabled',
                         'db_owner_id'
                     ] as $property) {
                unset($resources[$i]->{$property});
            }
        }

        return $resources;
    }
}
