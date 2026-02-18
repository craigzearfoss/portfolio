<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\ApplicationFactory;
use Eloquent;
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
 * @mixin Eloquent
 * @mixin Builder
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
        'job_duration_type_id',
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
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'company_id', 'role', 'job_board_id', 'resume_id', 'rating', 'active',
        'post_date', 'apply_date', 'close_date', 'compensation_min', 'compensation_max', 'compensation_unit_id',
        'job_duration_type_id', 'job_employment_type_id', 'job_location_type_id', 'street', 'street2', 'city',
        'state_id', 'zip', 'country_id', 'bonus', 'w2', 'relocation', 'benefits', 'vacation', 'health', 'phone',
        'phone_label', 'alt_phone', 'alt_phone_label', 'email', 'email_label', 'alt_email', 'alt_email_label',
        'public', 'readonly', 'root', 'disabled', 'demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['role', 'asc'];

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
     * @param array $filters
     * @param string $valueColumn
     * @param string $labelColumn
     * @param bool $includeOther
     * @param bool $includeBlank
     * @param array $orderBy
     * @return array
     * @throws Exception
     */
    public static function listOptions(array  $filters = [],
                                       string $valueColumn = 'id',
                                       string $labelColumn = 'name',
                                       bool   $includeOther = false,
                                       bool   $includeBlank = false,
                                       array  $orderBy = ['company_name', 'asc']): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $selectColumns = ['applications.id', 'applications.owner_id', 'role', 'apply_date', 'post_date',
            DB::raw('`companies`.`id` AS company_id'), DB::raw('`companies`.`name` AS company_name')
        ];
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        $query = new Application()->select($selectColumns)
            ->join('companies','companies.id', 'applications.company_id')
            ->orderBy($sortColumn, $sortDir);

        // Apply filters to the query.
        foreach ($filters as $col => $value) {
            if (in_array($col, ['id', 'owner_id'])) {
                $col = 'applications.' . $col;
            }
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
                    $query = $query->where($col, $value);
                }
            }
        }

        foreach ($query->get() as $row) {
            if ($labelColumn == 'name') {
                $label = (!empty($row->company_name) ? $row->company_name : '?company?') . ' - '
                    . ($row->role ?? '?role?')
                    . (!empty($row->apply_date)
                        ? ' [applied: ' . $row->apply_date . ']'
                        : (!empty($row->post_date) ? ' [applied: ' . $row->post_date . ']' : '')
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
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['company_id']), function ($query) use ($filters) {
                $query->where('company_id', '=', intval($filters['company_id']));
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->where('to', 'role', '%' . $filters['role'] . '%');
            })
            ->when(!empty($filters['job_board_id']), function ($query) use ($filters) {
                $query->where('job_board_id', '=', intval($filters['job_board_id']));
            })
            ->when(!empty($filters['resume_id']), function ($query) use ($filters) {
                $query->where('resume_id', '=', intval($filters['resume_id']));
            })
            ->when(isset($filters['rating']), function ($query) use ($filters) {
                $query->where('rating', '=', intval($filters['rating']));
            })
            ->when(isset($filters['active']), function ($query) use ($filters) {
                $query->where('active', '=', boolval(['active']));
            })
            ->when(!empty($filters['post_date']), function ($query) use ($filters) {
                $query->where('post_date', '=', $filters['post_date']);
            })
            ->when(!empty($filters['apply_date']), function ($query) use ($filters) {
                $query->where('apply_date', '=', $filters['apply_date']);
            })
            ->when(!empty($filters['close_date']), function ($query) use ($filters) {
                $query->where('close_date', '=', $filters['close_date']);
            })
            ->when(!empty($filters['compensation_min']), function ($query) use ($filters) {
                $query->where('compensation_min', '>=', intval($filters['compensation_min']));
            })
            ->when(!empty($filters['compensation_max']), function ($query) use ($filters) {
                $query->where('compensation_max', '<=', intval($filters['compensation_max']));
            })
            ->when(!empty($filters['compensation_unit_id']), function ($query) use ($filters) {
                $query->where('compensation_unit_id', '=', intval($filters['compensation_unit_id']));
            })
            ->when(!empty($filters['job_duration_type_id']), function ($query) use ($filters) {
                $query->where('job_duration_type_id', '=', intval($filters['job_duration_type_id']));
            })
            ->when(!empty($filters['job_location_type_id']), function ($query) use ($filters) {
                $query->where('job_location_type_id', '=', intval($filters['job_location_type_id']));
            })
            ->when(!empty($filters['job_employment_type_id']), function ($query) use ($filters) {
                $query->where('job_employment_type_id', '=', intval($filters['job_employment_type_id']));
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where('city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where('state_id', '=', intval($filters['state_id']));
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where('country_id', '=', intval($filters['country_id']));
            })
            ->when(isset($filters['relocation']), function ($query) use ($filters) {
                $query->where('relocation', '=', boolval($filters['relocation']));
            })
            ->when(isset($filters['benefits']), function ($query) use ($filters) {
                $query->where('benefits', '=', boolval($filters['benefits']));
            })
            ->when(isset($filters['vacation']), function ($query) use ($filters) {
                $query->where('vacation', '=', boolval($filters['vacation']));
            })
            ->when(isset($filters['health']), function ($query) use ($filters) {
                $query->where('health', '=', boolval($filters['health']));
            })
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $email = $filters['email'];
                $query->orWhere(function ($query) use ($email) {
                    $query->where('email', 'LIKE', '%' . $email . '%')
                        ->orWhere('alt_email', 'LIKE', '%' . $email . '%');
                });
            })
            ->when(!empty($filters['phone']), function ($query) use ($filters) {
                $phone = $filters['phone'];
                $query->orWhere(function ($query) use ($phone) {
                    $query->where('phone', 'LIKE', '%' . $phone . '%')
                        ->orWhere('alt_phone', 'LIKE', '%' . $phone . '%');
                });
            });

        return $this->appendStandardFilters($query, $filters);
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
        $date = !empty($this->apply_date)
            ? ' [applied: ' . $this->apply_date . ']'
            : (!empty($this->post_date) ? ' [applied: ' . $this->apply_date . ']' : '');

        return $company . ' - ' . $role /* . $date */;
    }

    /**
     * Get the career communications for the application.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'application_id')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');
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
            ->orderBy('date', 'desc');
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
            ->orderBy('date', 'desc');
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
     * Get the career resume that owns the application.
     */
    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class)->orderBy('date', 'desc')
            ->orderBy('name');
    }

    /**
     * Get the career skills for the application.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(ApplicationSkill::class, 'application_id')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');
    }
    /**
     * Get the system state that owns the application.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }
}
