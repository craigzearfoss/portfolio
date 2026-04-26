<?php

namespace App\Models\Portfolio;

use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Models\System\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class School extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'schools';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'enrollment',
        'founded',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'notes',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
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
        'state_code', 'state_name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'enrollment', 'founded', 'street', 'street2', 'city', 'state_id',
        'zip', 'country_id', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled',
        'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'is_demo|desc'       => 'demo',
        'is_disabled|desc'   => 'disabled',
        'featured|desc'      => 'featured',
        'id|asc'             => 'id',
        'name|asc'           => 'name',
        'owner_id|asc'       => 'owner id',
        'owner_name|asc'     => 'owner name',
        'owner_username|asc' => 'owner username',
        'is_public|desc'     => 'public',
        'is_readonly|desc'   => 'read-only',
        'is_root|desc'       => 'root',
        'sequence|asc'       => 'sequence',
        'state_name|asc'     => 'state',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'name', 'state_name', ],
        'guest' => [ 'name', 'state_name' ],
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

        $query = $this->getSearchQuery($filters, false)
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['enrollment']), function ($query) use ($filters) {
                $query->where($this->table . '.enrollment', '=', intval(['enrollment']));
            })
            ->when(!empty($filters['founded']), function ($query) use ($filters) {
                $query->where($this->table . '.founded', '=', intval(['founded']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            });

        // join to states table
        $query->join( dbName('system_db') . '.states', 'states.id', '=', $this->table . '.state_id')
            ->addSelect(DB::Raw('states.code as state_code'))
            ->addSelect(DB::Raw('states.name as state_name'));

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system country that owns the school.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the portfolio educations for the school.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'school_id');
    }

    /**
     * Get the system state that owns the school.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the portfolio students for the school.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Admin::class, 'school_id');
    }
}
