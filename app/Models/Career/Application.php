<?php

namespace App\Models\Career;

use App\Models\Scopes\AccessGlobalScope;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ApplicationFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

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
        'link',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AccessGlobalScope());
    }

    /**
     * Get the owner of the application.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the communications for the application.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'application_id')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');
    }

    /**
     * Get the company that owns the application.
     */
    public function company(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Company::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the compensation unit that owns the application.
     */
    public function compensationUnit(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(
            CompensationUnit::class, 'compensation_unit_id');
    }

    /**
     * Get the country that owns the career country.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the cover letter for the application.
     */
    public function coverLetter(): HasOne
    {
        return $this->setConnection('career_db')->hasOne(CoverLetter::class, 'application_id')
            ->orderBy('date', 'desc');
    }

    /**
     * Get the job duration type that owns the application.
     */
    public function durationType(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(
            JobDurationType::class, 'job_duration_type_id');
    }

    /**
     * Get the job employment type that owns the application.
     */
    public function employmentType(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(
            JobEmploymentType::class, 'job_employment_type_id');
    }

    /**
     * Get the events for the application.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'application_id')
            ->orderBy('date', 'desc');
    }

    /**
     * Get the job board who owns the application.
     */
    public function jobBoard(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(JobBoard::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the job location type that owns the application.
     */
    public function locationType(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(
            JobLocationType::class,'job_location_type_id');
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
     * Calculate the name of the application.
     */
    protected function calculateName()
    {
        $company = $this->company['name'] ?? '?company?';
        $role = $this->role ?? '?role?';
        $date = !empty($this->apply_date)
            ? ' [applied: ' . $this->apply_date . ']'
            : (!empty($this->post_date) ? ' [applied: ' . $this->apply_date . ']' : '');

        return $company . ' - ' . $role . $date;
    }

    /**
     * Get the notes for the application.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'application_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the resume that owns the application.
     */
    public function resume(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Resume::class)
            ->orderBy('name', 'asc');
    }


    /**
     * Get the skills for the application.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(ApplicationSkill::class, 'application_id')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');
    }
    /**
     * Get the state that owns the application.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(State::class, 'state_id');
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
     * @throws \Exception
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

        $query = Application::select($selectColumns)
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
                        throw new \Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
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
}
