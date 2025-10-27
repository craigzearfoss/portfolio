<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Database extends Model
{
    use SearchableModelTrait;

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
        'guest',
        'user',
        'admin',
        'global',   // the database has no owner
        'icon',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'database', 'tag', 'title', 'plural', 'guest', 'user', 'admin',
        'icon', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the admin who owns the database.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the owner of the database.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class)->orderBy('name', 'asc');
    }

    public static function getResources(string | null $dbName = null,
                                        array $filters = [],
                                        array $orderBy = ['seq', 'asc']):  array
    {
        $query = Database::select( 'resources.*', 'databases.id as database_id', 'databases.name as database_name'
            , 'databases.database as database_database'
        )
            ->join('resources', 'resources.database_id', '=', 'databases.id')
            ->orderBy('resources.sequence', 'asc');

        if(!empty($dbName)) {
            $query->where('databases.name', $dbName);
        }

        if (isset($filters['public'])) $query->where('resources.public', boolval($filters['public']) ? 1 : 0);
        if (isset($filters['readonly'])) $query->where('resources.readonly', boolval($filters['readonly']) ? 1 : 0);
        if (isset($filters['root'])) $query->where('resources.root', boolval($filters['root']) ? 1 : 0);
        if (isset($filters['disabled'])) $query->where('resources.disabled', boolval($filters['disabled']) ? 1 : 0);

        return $query->get()->toArray();
    }
}
