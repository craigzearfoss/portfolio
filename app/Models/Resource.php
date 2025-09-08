<?php

namespace App\Models;

use App\Http\Requests\ResourceStoreRequest;
use App\Models\Database;
use App\Services\PermissionService;
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
    protected $connection = 'default_db';

    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'database_id',
        'name',
        'table',
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
     * Get the database that owns the resource.
     */
    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class, 'database_id');
    }

    /**
     * Returns the resources for the user type sorted by database and resource sequence.
     *
     * @param string $userType
     * @param bool $isRoot
     * @return Collection
     * @throws \Exception
     */
    public function bySequence(string $userType, bool $isRoot = false): Collection
    {
        if (!in_array($userType, PermissionService::USER_TYPES)) {
            throw new \Exception('User type not supported');
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
                DB::raw('databases.admin_id as db_admin_id'),
                'resources.*'
            ]
        )
            ->join('databases', 'databases.id', 'resources.database_id')
            ->where('databases.'.$userType, 1)
            ->where('resources.'.$userType, 1)
            ->orderBy('databases.sequence', 'asc')
            ->orderBy('resources.sequence', 'asc');

        if (!$isRoot) {
            // Only root users have access to disabled databases.
            $query->where('databases.disabled', 0)
                ->where('resources.disabled', 0);
        }

        //return $query->get();

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
                'admin_id' => $resources[$i]->db_admin_id,
            ];
            foreach (['db_id', 'db_name', 'db_database', 'db_tag', 'db_title', 'db_plural', 'db_guest', 'db_user',
                         'db_admin', 'db_icon', 'db_sequence', 'db_public', 'db_readonly', 'db_root', 'db_disabled',
                         'db_admin_id'
                     ] as $property) {
                unset($resources[$i]->{$property});
            }
        }

        return $resources;
    }
}
