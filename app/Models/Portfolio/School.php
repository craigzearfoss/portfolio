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
        'summary',
        'active',
        'public',
        'private',
        'male',
        'female',
        'enrollment',
        'founded',
        'closed',
        'community_college',
        'technical',
        'hbcu',
        'religious',
        'seminary',
        'medical',
        'former_names',
        'nickname',
        'mascot',
        'colors',
        'religious_affiliation',
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
        'wikipedia',
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
        'favorite_count',
    ];

    /**
     *
     */
    const array TYPES = [
        'public',
        'private',
    ];

    /**
     *
     */
    const array GENDERS = [
        'coed',
        'female',
        'male'
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'country_iso_alpha3', 'country_name',
        'state_code', 'state_name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'summary', 'active', 'type', 'gender','enrollment', 'founded',
        'street', 'street2', 'city', 'closed', 'community_college', 'technical', 'hbcu', 'religious', 'seminary',
        'medical', 'former_names', 'nickname', 'mascot', 'colors', 'religious_affiliation', 'street', 'street2',
        'city', 'state_id', 'zip', 'country_id', 'notes', 'link', 'link_name', 'wikipedia', 'description',
        'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'sequence', 'favorite_count',
        'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'city|asc'            => 'city',
        'closed|asc'          => 'closed',
        'created_at|desc'     => 'datetime created',
        'updated_at|desc'     => 'datetime updated',
        'is_demo|desc'        => 'demo',
        //'description|asc'     => 'description',
        'is_disabled|desc'    => 'disabled',
        'favorite_count|desc' => 'favorite count',
        'founded|asc'         => 'founded',
        'featured|desc'       => 'featured',
        'gender|asc'          => 'gender',
        'id|asc'              => 'id',
        'link|asc'            => 'link',
        'link_name|asc'       => 'link name',
        'name|asc'            => 'name',
        //'notes|asc'           => 'notes',
        'owner_id|asc'        => 'owner id',
        'owner_name|asc'      => 'owner name',
        'owner_username|asc'  => 'owner username',
        'is_public|desc'      => 'public',
        'is_readonly|desc'    => 'read-only',
        'is_root|desc'        => 'root',
        'sequence|asc'        => 'sequence',
        'state_name|asc'      => 'state',
        'type|asc'            => 'type',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'city', 'favorite_count', 'founded', 'name', 'state_name' ],
        'guest' => [ 'city', 'founded', 'name', 'state_name' ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns an array of options for a select list for types, i.e. public or private.
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public function typeListOptions(bool $includeBlank = false): array
    {
        $options = $includeBlank ? [ '' => '' ] : [];

        foreach (self::TYPES as $type) {
            $options[$type] = $type;
        }

        return $options;
    }

    /**
     * Returns an array of options for a select list for genders, i.e. coed, female, male.
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public function genderListOptions(bool $includeBlank = false): array
    {
        $options = $includeBlank ? [ '' => '' ] : [];

        foreach (self::GENDERS as $gender) {
            $options[$gender] = $gender;
        }

        return $options;
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
            ->when(!empty($filters['active']), function ($query) use ($filters) {
                $query->where($this->table . '.active', '=', true);
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where($this->table . '.city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['closed']), function ($query) use ($filters) {
                $query->where($this->table . '.closed', '=', intval($filters['closed']));
            })
            ->when(!empty($filters['coed']), function ($query) use ($filters) {
                $query->where(function ($query) use($filters) {
                    $query->where($this->table . '.female', '=', true)
                        ->orWhere($this->table . '.male', '=', true);
                });
            })
            ->when(!empty($filters['colors']), function ($query) use ($filters) {
                $query->where($this->table . '.colors', 'like', '%' . $filters['colors'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['enrollment']), function ($query) use ($filters) {
                $query->where($this->table . '.enrollment', '=', intval($filters['enrollment']));
            })
            ->when(!empty($filters['favorites']), function ($query) use ($filters) {
                $query->whereIn($this->table . '.id', explode('|', $filters['favorites']));
            })
            ->when(!empty($filters['former_names']), function ($query) use ($filters) {
                $query->where($this->table . '.former_names', 'like', '%' . $filters['former_names'] . '%');
            })
            ->when(!empty($filters['founded']), function ($query) use ($filters) {
                $query->where($this->table . '.founded', '=', intval($filters['founded']));
            })
            ->when(!empty($filters['gender']), function ($query) use ($filters) {
                $query->where($this->table . '.gender', '=', strtolower($filters['gender']));
            })
            ->when(!empty($filters['link']), function ($query) use ($filters) {
                $query->where($this->table . '.link', 'like', '%' . $filters['link'] . '%');
            })
            ->when(!empty($filters['link_name']), function ($query) use ($filters) {
                $query->where($this->table . '.link_name', 'like', '%' . $filters['link_name'] . '%');
            })
            ->when(!empty($filters['mascot']), function ($query) use ($filters) {
                $query->where($this->table . '.mascot', 'like', '%' . $filters['mascot'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['nickname']), function ($query) use ($filters) {
                $query->where($this->table . '.nickname', 'like', '%' . $filters['nickname'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['seminary']), function ($query) use ($filters) {
                $query->where($this->table . '.seminary', '=', true);
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where($this->table . '.state_id', '=', intval($filters['state_id']));
            })
            ->when(!empty($filters['type']), function ($query) use ($filters) {
                $query->where($this->table . '.type', '=', strtolower($filters['type']));
            })
            ->when(!empty($filters['wikipedia']), function ($query) use ($filters) {
                $query->where($this->table . '.wikipedia', 'like', '%' . $filters['wikipedia'] . '%');
            });

        $community_college = boolval($filters['community_college'] ?? false);
        $hbcu              = boolval($filters['hbcu'] ?? false);
        $medical           = boolval($filters['medical'] ?? false);
        $religious         = boolval($filters['religious'] ?? false);
        $technical         = boolval($filters['technical'] ?? false);
        if ($community_college || $hbcu || $medical || $religious || $technical) {
            $query->where(function ($query) use ($community_college, $hbcu, $medical, $religious, $technical) {
                if ($community_college) $query->orWhere($this->table . '.community_college', '=', true);
                if ($hbcu) $query->orWhere($this->table . '.hbcu', '=', true);
                if ($medical) $query->orWhere($this->table . '.medical', '=', true);
                if ($religious) $query->orWhere($this->table . '.religious', '=', true);
                if ($technical) $query->orWhere($this->table . '.technical', '=', true);
            });
        }

        // join to states table
        $query->join( dbName('system_db') . '.states', 'states.id', '=', $this->table . '.state_id')
            ->leftJoin(dbName('system_db') . '.countries', 'countries.id', '=', $this->table . '.country_id');

        $query->select([
            DB::raw('schools.*'),
            DB::raw('states.code as state_code'),
            DB::raw('states.name as state_name'),
            DB::raw('countries.iso_alpha3 as country_iso_alpha3'),
            DB::raw('countries.name as country_name'),
        ] );

        $query->with('state', 'country');

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
