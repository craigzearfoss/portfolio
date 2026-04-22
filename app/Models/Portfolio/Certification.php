<?php

namespace App\Models\Portfolio;

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
class Certification extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'certifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'abbreviation',
        'certification_type_id',
        'organization',
        'notes',
        'link',
        'link_name',
        'description',
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
    const array PREDEFINED_SEARCH_COLUMNS = [ 'type_name' ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'abbreviation', 'certification_type_id', 'organization',
        'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'abbreviation|asc' => 'abbreviation',
        'created_at|desc'  => 'datetime created',
        'updated_at|desc'  => 'datetime updated',
        'id|asc'           => 'id',
        'name|asc'         => 'name',
        'sequence|asc'     => 'sequence',
        'type_name|asc'    => 'type',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'abbreviation', 'is_disabled', 'name', 'is_public', ],
        'guest' => [ 'abbreviation', 'name', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
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

        $query = new self()->select(
            DB::raw(dbName($this->connection) . '.' . $this->table . '.*')
        );

        $query = $this->appendStandardFilters($query, $filters)
            ->when(!empty($filters['abbreviation']), function ($query) use ($filters) {
                $query->where($this->table . '.abbreviation', 'like', '%' . $filters['abbreviation'] . '%');
            })
            ->when(!empty($filters['certification_type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.certification_type_id', '=', intval($filters['certification_type_id']));
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['organization']), function ($query) use ($filters) {
                $query->where('organization', 'like', '%' . $filters['organization'] . '%');
            });

        // join to certification_types table
        $query->join( dbName('portfolio_db') . '.certification_types', 'certification_types.id', '=', $this->table . '.certification_type_id')
            ->addSelect(DB::Raw('certification_types.name as type_name'));

        // select columns
        $query->select(
            DB::raw(dbName($this->connection) . '.' . $this->table . '.*'),
            DB::raw(dbName('portfolio_db') . '.certification_types.name AS `type_name`')
        );

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the portfolio certification type that owns the certification.
     */
    public function certificationType(): BelongsTo
    {
        return $this->belongsTo(CertificationType::class, 'certification_type_id');
    }
}
