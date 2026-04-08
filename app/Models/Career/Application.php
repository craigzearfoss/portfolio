<?php

namespace App\Models\Career;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\ApplicationFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Application extends Model
{
    /** @use HasFactory<ApplicationFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'company_id',
        'role',
        'job_board_id',
        'resume_id',
        'rating',
        'active',
        'post_date',
        'apply_date',
        'close_date',
        'compensation_min',
        'compensation_max',
        'compensation_unit_id',
        'estimated_hours',
        'wage_rate',
        'job_duration_type_id',
        'job_location_type_id',
        'job_employment_type_id',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'bonus',
        'w2',
        'relocation',
        'benefits',
        'vacation',
        'health',
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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'company_id', 'role', 'job_board_id', 'resume_id', 'rating',
        'active', 'post_date', 'apply_date', 'close_date', 'compensation_min', 'compensation_max',
        'compensation_unit_id', 'estimated_hours', 'wage_rate', 'job_duration_type_id', 'job_location_type_id',
        'job_employment_type_id', 'street', 'street2', 'city', 'state_id', 'zip', 'country_id', 'bonus', 'w2',
        'relocation', 'benefits', 'vacation', 'health', 'phone', 'phone_label', 'alt_phone', 'alt_phone_label',
        'email', 'email_label', 'alt_email', 'alt_email_label', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'post_date', 'desc' ];

    /**
     *
     */
    const array RATINGS = [
        1 => '1 star',
        2 => '2 stars',
        3 => '3 stars',
        4 => '4 stars',
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [
            'company_name',
        ];
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
            $this->table . '.role',
            $this->table . '.apply_date',
            DB::raw('companies.name AS `company_name`'),
        ];

        foreach ([$valueColumn, $labelColumn] as $field) {
            if (!empty($field) && ($field !== 'name')) {
                // note that there is no "name" column in the applications table
                if ($field = $this->fullyQualifiedField($field)) {
                    if (!in_array($field, $selectColumns)) {
                        $selectColumns[] = $field;
                    }
                }
            }
        }

        // set the order by
        $sortColumn = $orderBy[0] ?? self::SEARCH_ORDER_BY[0];
        if (!in_array($sortColumn, $selectColumns) && !in_array($sortColumn, $this->predefinedColumns)) {
            $selectColumns[] = $sortColumn;
        }
        $sortDir = $orderBy[1] ?? self::SEARCH_ORDER_BY[1];

        // create the query
        if ($envType == EnvTypes::ADMIN) {
            $query = new self()->withoutGlobalScope(AdminPublicScope::class)
                ->distinct()->select($selectColumns)->orderBy($sortColumn, $sortDir)
                ->join('companies','companies.id', 'applications.company_id')
                ->orderBy($sortColumn, $sortDir);
        } else {
            $query = new self()->distinct()->select($selectColumns)
                ->join('companies','companies.id', 'applications.company_id')
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
                // there is no name column for applications so we need to generate one
                $label = (!empty($row->company_name) ? $row->company_name : '?company?') . ' - '
                    . ($row->role ?? '?role?')
                    . (!empty($row->apply_date)
                        ? ' [applied: ' . $row->apply_date . ']'
                        : (!empty($row->post_date) ? ' [posted: ' . $row->post_date . ']' : '')
                    );
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
     * @TODO: Need to add joins for company_ids to be searched.
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

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['active']), function ($query) use ($filters) {
                $query->where($this->table . '.active', '=', true);
            })
            ->when(!empty($filters['apply_date']), function ($query) use ($filters) {
                $query->where($this->table . '.apply_date', '=', $filters['apply_date']);
            })
            ->when(!empty($filters['applied_from']), function ($query) use ($filters) {
                $query->where($this->table . '.apply_date', '>=', $filters['applied_from']);
            })
            ->when(!empty($filters['applied_to']), function ($query) use ($filters) {
                $query->where($this->table . '.apply_date', '<=', $filters['applied_to']);
            })
            ->when(isset($filters['bonus']), function ($query) use ($filters) {
                $query->where($this->table . '.bonus', '=', intval($filters['bonus']));
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where($this->table . '.city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['close_date']), function ($query) use ($filters) {
                $query->where($this->table . '.close_date', '=', $filters['close_date']);
            })
            ->when(!empty($filters['closed_from']), function ($query) use ($filters) {
                $query->where($this->table . '.close_date', '>=', $filters['closed_from']);
            })
            ->when(!empty($filters['closed_to']), function ($query) use ($filters) {
                $query->where($this->table . '.close_date', '<=', $filters['closed_to']);
            })
            ->when(!empty($filters['company_id']), function ($query) use ($filters) {
                $query->where($this->table . '.company_id', '=', intval($filters['company_id']));
            })
            ->when(!empty($filters['company_name']), function ($query) use ($filters) {
                $query->where('companies.name', 'like', '%' . $filters['company_name'] . '%');
            })
            ->when(!empty($filters['compensation_min']), function ($query) use ($filters) {
                $query->where('compensation_min', 'like', '%' . $filters['compensation_min'] . '%');
            })
            ->when(!empty($filters['compensation_max']), function ($query) use ($filters) {
                $query->where('compensation_max', 'like', '%' . $filters['compensation_max'] . '%');
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where($this->table . '.country_id', '=', intval($filters['country_id']));
            })
            ->when(!empty($filters['benefits']), function ($query) use ($filters) {
                $query->where($this->table . '.benefits', '=', true);
            })
            ->when(!empty($filters['compensation_max']), function ($query) use ($filters) {
                $query->where($this->table . '.compensation_max', '<=', intval($filters['compensation_max']));
            })
            ->when(!empty($filters['compensation_min']), function ($query) use ($filters) {
                $query->where($this->table . '.compensation_min', '>=', intval($filters['compensation_min']));
            })
            ->when(!empty($filters['compensation_unit_id']), function ($query) use ($filters) {
                $query->where($this->table . '.compensation_unit_id', '=', intval($filters['compensation_unit_id']));
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['estimated_hours']), function ($query) use ($filters) {
                $query->where($this->table . '.estimated_hours', '<=', intval($filters['estimated_hours']));
            })
            ->when(!empty($filters['health']), function ($query) use ($filters) {
                $query->where($this->table . '.health', '=', true);
            })
            ->when(!empty($filters['job_board_id']), function ($query) use ($filters) {
                $query->where($this->table . '.job_board_id', '=', intval($filters['job_board_id']));
            })
            ->when(!empty($filters['job_duration_type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.job_duration_type_id', '=', intval($filters['job_duration_type_id']));
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
            ->when(!empty($filters['post_date']), function ($query) use ($filters) {
                $query->where($this->table . '.post_date', '=', $filters['post_date']);
            })
            ->when(!empty($filters['posted_from']), function ($query) use ($filters) {
                $query->where($this->table . '.post_date', '>=', $filters['posted_from']);
            })
            ->when(!empty($filters['posted_to']), function ($query) use ($filters) {
                $query->where($this->table . '.post_date', '<=', $filters['posted_to']);
            })
            ->when(!empty($filters['rating']), function ($query) use ($filters) {
                $query->where($this->table . '.rating)', '=', intval($filters['rating']));
            })
            ->when(!empty($filters['max_rating']), function ($query) use ($filters) {
                $query->where($this->table . '.rating', '<=', intval($filters['max_rating']));
            })
            ->when(!empty($filters['min_rating']), function ($query) use ($filters) {
                $query->where($this->table . '.rating', '>=', intval($filters['min_rating']));
            })
            ->when(!empty($filters['relocation']), function ($query) use ($filters) {
                $query->where($this->table . '.relocation', '=', true);
            })
            ->when(!empty($filters['resume_id']), function ($query) use ($filters) {
                $query->where($this->table . '.resume_id', '=', intval($filters['resume_id']));
            })
            ->when(!empty($filters['resume_name']), function ($query) use ($filters) {
                $query->where('resumes.name', 'like', '%' . $filters['resume_name'] . '%');
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->where($this->table . '.role', 'like', '%' . $filters['role'] . '%');
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where($this->table . '.state_id', '=', intval($filters['state_id']));
            })
            ->when(!empty($filters['status']), function ($query) use ($filters) {
                if (intval($filters['status']) > 1) {
                    $query->where($this->table . '.active', '=', true);
                } elseif (intval($filters['status']) == 1) {
                    $query->where($this->table . '.active', '=', false);
                }
            })
            ->when(!empty($filters['vacation']), function ($query) use ($filters) {
                $query->where($this->table . '.vacation', '=', true);
            })
            ->when(!empty($filters['w2']), function ($query) use ($filters) {
                $query->where($this->table . '.w2', '=', true);
            })
            ->when(!empty($filters['wage_rate']), function ($query) use ($filters) {
                $query->where('wage_rate', 'like', '>=' . intval($filters['wage_rate']));
            });

        // add additional filters
        $query = $this->appendPhoneFilters($query, $filters);
        $query = $this->appendEmailFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add joins
        $query->join( dbName('system_db') . '.admins', 'admins.id', '=', $this->table . '.owner_id');
        $query->join('companies', 'companies.id', '=', 'applications.company_id');
        $query->leftJoin('resumes', 'resumes.id', '=', 'applications.resume_id');
        $query->select([
            DB::raw($this->table . '.*'),
            DB::raw('admins.name AS `owner_name`'),
            DB::raw('admins.username AS `owner_username`'),
            DB::raw('admins.email AS `owner_email`'),
            DB::raw('companies.name as company_name'),
            DB::raw('resumes.name as resume_name'),
        ]);

        // add order by clause
        $query = $this->addOrderBy($query, $sort);
        if (explode('|', $sort ?? '') != 'owner_username') {
            $query->orderBy('owner_username');
        }

        return $query;
    }

    /**
     * Get the system owner of the application.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career notes for the application.
     */
    public function application_notes(): HasMany
    {
        return $this->hasMany(Note::class, 'application_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Calculate the name of the application.
     *
     * @return string
     */
    protected function calculateName(): string
    {
        $company = $this->company['name'] ?? '?company?';
        $role = $this->role ?? '?role?';
        /*
        $date = !empty($this->apply_date)
            ? ' [applied: ' . $this->apply_date . ']'
            : (!empty($this->post_date) ? ' [applied: ' . $this->apply_date . ']' : '');
        */

        return $company . ' - ' . $role /* . $date */;
    }

    /**
     * Get the career communications for the application.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'application_id')
            ->orderBy('communication_datetime', 'desc');
    }

    /**
     * Get the career company that owns the application.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')
            ->orderBy('name');
    }

    /**
     * Get the career compensation unit that owns the application.
     */
    public function compensationUnit(): BelongsTo
    {
        return $this->belongsTo(CompensationUnit::class, 'compensation_unit_id');
    }

    /**
     * Get the system country that owns the career country.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the career cover letter for the application.
     */
    public function coverLetter(): HasOne
    {
        return $this->setConnection('career_db')->hasOne(CoverLetter::class, 'application_id')
            ->orderBy('cover_letter_date', 'desc');
    }

    /**
     * Get the career job duration type that owns the application.
     */
    public function durationType(): BelongsTo
    {
        return $this->belongsTo(JobDurationType::class, 'job_duration_type_id');
    }

    /**
     * Get the career job employment type that owns the application.
     */
    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(JobEmploymentType::class, 'job_employment_type_id');
    }

    /**
     * Get the career events for the application.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'application_id')
            ->orderBy('event_date', 'desc');
    }

    /**
     * Get the career job board that owns the application.
     */
    public function jobBoard(): BelongsTo
    {
        return $this->belongsTo(JobBoard::class, 'job_board_id')
            ->orderBy('name');
    }

    /**
     * Get the career job search log entries for the application.
     */
    public function jobSearchLogEntries(): HasMany
    {
        return $this->hasMany(JobSearchLog::class, 'application_id')
            ->orderBy('time_logged', 'desc');
    }

    /**
     * Get the career job location type that owns the application.
     */
    public function locationType(): BelongsTo
    {
        return $this->belongsTo(JobLocationType::class,'job_location_type_id');
    }

    /**
     * Get the name of the application.
     */
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->calculateName()
        );
    }

    /**
     * Get the career notes for the application.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Event::class, 'application_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the career resume that owns the application.
     */
    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class)->orderBy('resume_date', 'desc')
            ->orderBy('name');
    }

    /**
     * Get the career skills for the application.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(ApplicationSkill::class, 'application_id')
            ->orderBy('name');
    }
    /**
     * Get the system state that owns the application.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }
}
