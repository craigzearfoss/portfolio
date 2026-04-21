<?php

namespace App\Models\Portfolio;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Models\System\ResourceSetting;
use App\Models\System\State;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\JobFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     *
     */
    const string DATABASE_TAG = 'portfolio_db';

    /**
     * @var string
     */
    protected $connection = self::DATABASE_TAG;

    /**
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'company',
        'role',
        'slug',
        'featured',
        'summary',
        'start_date',
        'end_date',
        'job_employment_type_id',
        'job_location_type_id',
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
        'disclaimer',
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
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'company', 'role', 'featured', 'summary', 'start_date',
        'end_date', 'job_employment_type_id', 'job_location_type_id', 'street', 'street2', 'city', 'state_id',
        'zip', 'country_id', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root',
        'is_disabled', 'is_demo' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'start_date', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'all' => [
            'company|asc'        => 'company',
            'end_date|desc'      => 'date ended',
            'start_date|desc'    => 'date started',
            'created_at|desc'    => 'datetime created',
            'updated_at|desc'    => 'datetime updated',
            'is_demo|desc'       => 'demo',
            'is_disabled|desc'   => 'disabled',
            'featured|desc'      => 'featured',
            'id|asc'             => 'id',
            'owner_id|asc'       => 'owner id',
            'owner_name|asc'     => 'owner name',
            'owner_username|asc' => 'owner username',
            'is_public|desc'     => 'public',
            'is_readonly|desc'   => 'read-only',
            'role|asc'           => 'role',
            'is_root|desc'       => 'root',
            'sequence|asc'       => 'sequence',
        ],
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
     * Returns an array of options for an application select list.
     *
     * @param array       $filters
     * @param string      $valueColumn
     * @param string|null $labelColumn
     * @param bool        $includeBlank
     * @param bool        $includeOther
     * @param array       $orderBy
     * @param EnvTypes    $envType
     * @return array
     * @throws Exception
     */
    public function listOptions(array       $filters = [],
                                string      $valueColumn = 'id',
                                string|null $labelColumn = 'id',
                                bool        $includeBlank = false,
                                bool        $includeOther = false,
                                array       $orderBy = [],
                                EnvTypes    $envType = EnvTypes::GUEST): array
    {
        $options = $includeBlank ? [ '' => '' ] : [];

        // set the columns
        $selectColumns = [
            $this->table . '.id',
            $this->table . '.company',
            $this->table . '.role',
        ];

        foreach ([$valueColumn, $labelColumn] as $field) {
            if (!empty($field) && ($field !== 'name')) {
                // note that there is no "name" column in the jobs table
                if ($field = $this->fullyQualifiedField($field)) {
                    if (!in_array($field, $selectColumns)) {
                        $selectColumns[] = $field;
                    }
                }
            }
        }

        // set the order by
        $sortColumn = $orderBy[0] ?? $this->table . '.company';
        if (!in_array($sortColumn, $selectColumns) && !in_array($sortColumn, self::PREDEFINED_SEARCH_COLUMNS)) {
            $selectColumns[] = $sortColumn;
        }
        $sortDir = $orderBy[1] ?? 'asc';

        // create the query
        if ($envType == EnvTypes::ADMIN) {
            $query = new self()->withoutGlobalScope(AdminPublicScope::class)
                ->distinct()->select($selectColumns)->orderBy($sortColumn, $sortDir)
                ->orderBy($sortColumn, $sortDir);
        } else {
            $query = new self()->distinct()->select($selectColumns)
                ->orderBy($sortColumn, $sortDir);
        }

        // apply filters to the query
        foreach ($filters as $col => $value) {

            // if the filter is owner_id and the value is null then ignore it because owner_id should always have a value
            if (($col == 'owner_id') && empty($value)) {
                continue;
            }

            // make sure common columns are fully qualified to avoid query errors
            if (in_array($col, self::COMMON_COLUMNS)) {
                $col = $this->table . '.' .$col;
            }

            // get the where clause
            if (is_array($value)) {
                $query = $query->whereIn($col, $value);
            } else {
                $parts = explode(' ', $col);
                $col = $parts[0];
                if (!empty($parts[1])) {
                    $operation = trim($parts[1]);
                    if (in_array($operation, ['<>', '!=', '=!'])) {
                        $query->whereNot($col, $value);
                    } elseif (strtolower($operation) == 'like') {
                        $query->whereLike($col, $value);
                    } else {
                        throw new Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($col, '=', $value);
                }
            }
        }

        foreach ($query->get() as $row) {
            if (empty($labelColumn) || ($labelColumn == 'name')) {
                // there is no name column for jobs so we need to generate one
                $label = $row->company . ' - ' . $row->role;
            } else {
                $label = $row->{$labelColumn};
            }

            $options[$row->{$valueColumn}] = $label;
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

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['company']), function ($query) use ($filters) {
                $query->where($this->table . '.company', 'like', '%' . $filters['company'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['end_date']), function ($query) use ($filters) {
                $query->where($this->table . '.end_date', '<=', intval($filters['end_date']));
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['job_employment_type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.job_employment_type_id', '=', intval($filters['job_employment_type_id']));
            })
            ->when(!empty($filters['job_location_type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.job_location_type_id', '=', intval($filters['job_location_type_id']));
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->where($this->table . '.role', 'like', '%' . $filters['role'] . '%');
            })
            ->when(!empty($filters['start_date']), function ($query) use ($filters) {
                $query->where($this->table . '.start_date', '<=', intval($filters['start_date']));
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            });

        // add additional filters
        $query = $this->appendAddressFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the job.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Calculate the name of the application.
     * *
     * @return string
     */
    protected function calculateName(): string
    {
        return $this->company . (!empty($this->role) ? ' (' . $this->role . ')' : '');
    }

    /**
     * Get the system country that owns the job.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the portfolio job coworkers for the job.
     */
    public function coworkers(): HasMany
    {
        return $this->hasMany(JobCoworker::class, 'job_id');
    }

    /**
     * Get the portfolio job employment type that owns the job.
     */
    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(JobEmploymentType::class, 'job_employment_type_id');
    }

    /**
     * Get the portfolio job location type that owns the job.
     */
    public function locationType(): BelongsTo
    {
        return $this->belongsTo(JobLocationType::class, 'job_location_type_id');
    }

    /**
     * Get the name of the job.
     */
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->calculateName()
        );
    }

    /**
     * Get the portfolio job skills for the job.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(JobSkill::class, 'job_id');
    }

    /**
     * Returns the current resume template.
     *
     * @param string|null $name
     * @return string
     */
    public static function resumeTemplate(string|null $name = null): string
    {
        if (empty($name)) {

            $name = 'default';

            if ($database = new Database()->where('tag', '=', self::DATABASE_TAG)->first()) {
                if ($resource = new Resource()->where('database_id', '=', $database->id)->where('table_name', 'jobs')->first()) {
                    $value = ResourceSetting::getSetting($resource->id, 'template');
                    if (!empty($value)) {
                        $name = $value;
                    }
                }
            }
        }

        return '_templates.resume.' . $name;
    }

    /**
     * Get the system state that owns the job.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the portfolio job tasks for the job.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(JobTask::class, 'job_id');
    }
}
