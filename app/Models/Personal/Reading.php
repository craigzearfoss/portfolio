<?php

namespace App\Models\Personal;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Reading extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'personal_db';

    /**
     * @var string
     */
    protected $table = 'readings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'title',
        'author',
        'slug',
        'featured',
        'summary',
        'publication_year',
        'fiction',
        'nonfiction',
        'paper',
        'audio',
        'wishlist',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'title', 'author', 'featured', 'summary', 'publication_year',
        'fiction', 'nonfiction', 'paper', 'audio', 'wishlist', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'title', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'audio|desc'           => 'audio',
        'author|asc'           => 'author',
        'created_at|desc'      => 'datetime created',
        'updated_at|desc'      => 'datetime updated',
        'is_demo|desc'         => 'demo',
        'is_disabled|desc'     => 'disabled',
        'featured|desc'        => 'featured',
        'id|asc'               => 'id',
        'owner_id|asc'         => 'owner id',
        'owner_name|asc'       => 'owner name',
        'owner_username|asc'   => 'owner username',
        'paper|desc'           => 'paper',
        'is_public|desc'       => 'public',
        'is_readonly|desc'     => 'read-only',
        'is_root|desc'         => 'root',
        'sequence|asc'         => 'sequence',
        'title|asc'            => 'title',
        'wishlist|desc'        => 'wishlist',
        'publication_year|asc' => 'year published',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'author', 'is_disabled', 'published', 'title', 'is_public', 'publication_year', ],
        'guest' => [ 'author', 'published', 'title', 'publication_year', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
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
     * @throws Exception
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->newQuery()
            ->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['audio']), function ($query) use ($filters) {
                $query->where($this->table . '.audio', '=', true);
            })
            ->when(!empty($filters['author']), function ($query) use ($filters) {
                $query->where($this->table . '.author', 'like', '%' . $filters['author'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', 'like', '%' . $filters['featured'] . '%');
            })
            ->when(!empty($filters['fiction']), function ($query) use ($filters) {
                $query->where($this->table . '.fiction', '=', true);
            })
            ->when(!empty($filters['nonfiction']), function ($query) use ($filters) {
                $query->where($this->table . '.nonfiction', '=', true);
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['paper']), function ($query) use ($filters) {
                $query->where($this->table . '.paper', '=', true);
            })
            ->when(!empty($filters['search_title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['search_title'] . '%');
            })
            ->when(!empty($filters['wishlist']), function ($query) use ($filters) {
                $query->where($this->table . '.wishlist', '=', true);
            });

        // add joins
        $query->join( dbName('system_db') . '.admins',
            dbName('system_db') . '.admins.id',
            '=',
            dbName($this->connection) . '.' . $this->table . '.owner_id'
        );

        $query->select(
            DB::raw(dbName($this->connection) . '.' . $this->table . '.*'),
            //DB::Raw('admins.name as owner_id'),
            DB::Raw('admins.name as owner_name'),
            DB::Raw('admins.username as owner_username'),
            DB::Raw('admins.email as owner_email'),
        );

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the reading.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }
}
