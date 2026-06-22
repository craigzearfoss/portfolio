<?php

namespace App\Models\Career;

use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\RecruiterFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Recruiter extends Model
{
    /** @use HasFactory<RecruiterFactory> */
    use SearchableModelTrait, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'recruiters';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'primary',
        'summary',
        'recruiter_industry_id',
        'specialties',
        'local',
        'regional',
        'national',
        'international',
        'founded',
        'linkedin_url',
        'jobs_url',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'phone',
        'phone_label',
        'alt_phone',
        'alt_phone_label',
        'email',
        'email_label',
        'alt_email',
        'alt_email_label',
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
    const array PREDEFINED_SEARCH_COLUMNS = [
        'country_iso_alpha3',
        'country_name',
        'industry_name',
        'state_code',
        'state_name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'primary', 'summary', 'recruiter_id', 'specialties', 'local',
        'regional', 'national', 'international', 'founded', 'linkedin_url', 'jobs_url',   'street', 'street2', 'city',
        'state_id', 'zip', 'country_id', 'phone', 'phone_label', 'alt_phone', 'alt_phone_label', 'email',
        'email_label', 'alt_email', 'alt_email_label', 'notes', 'link', 'link_name', 'description', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'sequence', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'city|asc'          => 'city',
        'country_name|asc'  => 'country',
        'created_at|desc'   => 'datetime created',
        'updated_at|desc'   => 'datetime updated',
        'is_demo|desc'      => 'demo',
        //'description|asc'   => 'description',
        'is_disabled|desc'  => 'disabled',
        'email|asc'         => 'email',
        'founded|asc'       => 'founded',
        'id|asc'            => 'id',
        'industry_name|asc' => 'industry',
        'link|asc'          => 'link',
        'link_name|asc'     => 'link name',
        'name|asc'          => 'name',
        //'notes|asc'         => 'notes',
        'phone|asc'         => 'phone',
        'is_public|desc'    => 'public',
        'is_readonly|desc'  => 'read-only',
        'is_root|desc'      => 'root',
        'sequence|asc'      => 'sequence',
        'state_name|asc'    => 'state',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'city', 'country_name', 'industry_name', 'founded', 'name', 'state_name' ],
        'guest' => [ 'city', 'country_name', 'industry_name', 'founded', 'name', 'state_name' ],
    ];

    /**
     *
     */
    const array COVERAGE_AREAS = [
        'local',
        'regional',
        'national',
        'international',
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
     * @param string|null $sort
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
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where($this->table . '.country_id', '=', intval($filters['country_id']));
            })
            ->when(!empty($filters['coverage_area']), function ($query) use ($filters) {
                if (in_array($filters['coverage_area'], self::COVERAGE_AREAS)) {
                    $query->where($this->table . '.'.$filters['coverage_area'], '=', true);
                } else {
                    throw new Exception('Invalid coverage_area "' . $filters['coverage_area'] . '" specified.'
                        . ' Valid coverage areas are "' . implode('", "', self::COVERAGE_AREAS) . '".');
                }
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where($this->table . '.city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['favorites']), function ($query) use ($filters) {
                $query->whereIn($this->table . '.id', explode('|', $filters['favorites']));
            })
            ->when(!empty($filters['founded']), function ($query) use ($filters) {
                $query->where($this->table . '.founded', '=', intval($filters['founded']));
            })
            ->when(!empty($filters['founded-min']), function ($query) use ($filters) {
                $query->where($this->table . '.founded', '>=', $filters['founded-min']);
            })
            ->when(!empty($filters['founded-max']), function ($query) use ($filters) {
                $query->where($this->table . '.founded', '<=', $filters['founded-max']);
            })
            ->when(!empty($filters['is_active']), function ($query) use ($filters) {
                $query->where($this->table . '.is_disabled', '=', false);
            })
            ->when(!empty($filters['is_disabled']), function ($query) use ($filters) {
                $query->where($this->table . '.is_disabled', '=', true);
            })
            ->when(!empty($filters['jobs_url']), function ($query) use ($filters) {
                $query->where($this->table . '.jobs_url', 'like', '%' . $filters['jobs_url'] . '%');
            })
            ->when(!empty($filters['link']), function ($query) use ($filters) {
                $query->where($this->table . '.link', 'like', '%' . $filters['link'] . '%');
            })
            ->when(!empty($filters['link_name']), function ($query) use ($filters) {
                $query->where($this->table . '.link_name', 'like', '%' . $filters['link_name'] . '%');
            })
            ->when(!empty($filters['linkedin_url']), function ($query) use ($filters) {
                $query->where($this->table . '.linkedin_url', 'like', '%' . $filters['linkedin_url'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['primary']), function ($query) use ($filters) {
                $query->where($this->table . '.primary', '=', true);
            })
            ->when(!empty($filters['recruiter_industry_id']), function ($query) use ($filters) {
                $query->where($this->table . '.recruiter_industry_id', '=', intval($filters['recruiter_industry_id']));
            })
            ->when(!empty($filters['specialties']), function ($query) use ($filters) {
                $query->where($this->table . '.specialties', 'like', '%' . $filters['specialties'] . '%');
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where($this->table . '.state_id', '=', intval($filters['state_id']));
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            });

        // add coverage areas
        if (!empty($filters['local']) || !empty($filters['regional']) || !empty($filters['national']) || !empty($filters['international'])) {
            $local         = boolval($filters['local'] ?? 0);
            $regional      = boolval($filters['regional']?? 0);
            $national      = boolval($filters['national'] ?? 0);
            $international = boolval($filters['international'] ?? 0);
            $query->where(function ($query) use ($local, $regional, $national, $international) {
                if ($local) {
                    $query->orWhere($this->table . '.local', '=', $local);
                }
                if ($regional) {
                    $query->orWhere($this->table . '.regional', '=', $regional);
                }
                if ($national) {
                    $query->orWhere($this->table . '.national', '=', $national);
                }
                if ($international) {
                    $query->orWhere($this->table . '.international', '=', $international);
                }
            });
        }

        // add joins
        $query->leftJoin(dbName('system_db') . '.states', 'states.id', '=', $this->table . '.state_id')
            ->leftJoin(dbName('system_db') . '.countries', 'countries.id', '=', $this->table . '.country_id')
            ->leftJoin( dbName('career_db') . '.recruiter_industries', 'recruiter_industries.id', '=', $this->table . '.recruiter_industry_id');

        $query->select([
            DB::raw('recruiters.*'),
            DB::raw('recruiter_industries.name as industry_name'),
            DB::raw('states.code as state_code'),
            DB::raw('states.name as state_name'),
            DB::raw('countries.iso_alpha3 as country_iso_alpha3'),
            DB::raw('countries.name as country_name'),
        ] );

        // add additional filters
        $query = $this->appendPhoneFilters($query, $filters);
        $query = $this->appendEmailFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the contacts for the recruiter.
     */
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class)->withPivot('active')
            ->orderBy('name');
    }

    /**
     * Get the coverage areas for the recruiter (international, national, regional, local).
     */
    protected function coverageAreas(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getCoverageAreas()
        );
    }

    /**
     * Return an array of coverage areas for the recruiter (international, national, regional, local).
     *
     * @return array
     */
    protected function getCoverageAreas(): array
    {
        $coverageAreas = [];
        if (!empty($this->international)) $coverageAreas[] = 'international';
        if (!empty($this->national)) $coverageAreas[] = 'national';
        if (!empty($this->regional)) $coverageAreas[] = 'regional';
        if (!empty($this->local)) $coverageAreas[] = 'local';

        return $coverageAreas;
    }

    /**
     * Get the career job search log entries for the cover letter.
     */
    public function jobSearchLogEntries(): HasMany
    {
        return $this->hasMany(JobSearchLog::class, 'application_id')
            ->orderBy('time_logged', 'desc');
    }

    /**
     * Get the system country that owns the recruiter.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the system state that owns the recruiter.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the career recruiter industry that owns the recruiter.
     */
    public function recruiterIndustry(): BelongsTo
    {
        return $this->belongsTo(RecruiterIndustry::class, 'recruiter_industry_id');
    }
}
