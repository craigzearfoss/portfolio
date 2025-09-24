<?php

namespace App\Models;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Collection;

class Database extends Model
{
    protected $connection = 'default_db';

    protected $table = 'databases';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'database',
        'tag',
        'title',
        'plural',
        'guest',
        'user',
        'admin',
        'icon',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
        'admin_id',
    ];

    /**
     * Get the resources for the database.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public static function getResources(string | null $dbName = null, array $params = []):  array
    {
        $query = Database::select( 'resources.*', 'databases.id as database_id', 'databases.name as database_name'
            , 'databases.database as database_database'
        )
            ->join('resources', 'resources.database_id', '=', 'databases.id')
            ->orderBy('resources.sequence', 'asc');

        if(!empty($dbName)) {
            $query->where('databases.name', $dbName);
        }

        if (isset($params['public'])) $query->where('resources.public', boolval($params['public']) ? 1 : 0);
        if (isset($params['readonly'])) $query->where('resources.readonly', boolval($params['readonly']) ? 1 : 0);
        if (isset($params['root'])) $query->where('resources.root', boolval($params['root']) ? 1 : 0);
        if (isset($params['disabled'])) $query->where('resources.disabled', boolval($params['disabled']) ? 1 : 0);

        return $query->get()->toArray();
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (Database::select('id', 'database')->orderBy('database', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id ] = $row->name;
        }

        return $options;
    }
}
