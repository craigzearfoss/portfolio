<?php

namespace App\Models\Career;

use App\Models\Career\ApplicationCompensationUnit;
use App\Models\Career\ApplicationDuration;
use App\Models\Career\ApplicationOffice;
use App\Models\Career\ApplicationSchedule;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\JobBoard;
use App\Models\Career\Note;
use App\Models\Career\Resume;
use App\Models\Country;
use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\State;
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
        'duration_id',
        'office_id',
        'schedule_id',
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

        static::addGlobalScope(new AdminGlobalScope());
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
     * Get the application compensation unit that owns the application.
     */
    public function compensation_unit(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(ApplicationCompensationUnit::class);
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
    public function cover_letter(): HasOne
    {
        return $this->setConnection('career_db')->hasOne(CoverLetter::class, 'application_id')
            ->orderBy('date', 'desc');
    }

    /**
     * Get the application duration that owns the application.
     */
    public function duration(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(ApplicationDuration::class);
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
     * Get the job_board who owns the application.
     */
    public function job_board(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(JobBoard::class)
            ->orderBy('name', 'asc');
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
     * Get the application office that owns the application.
     */
    public function office(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(ApplicationOffice::class);
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
     * Get the application schedule that owns the application.
     */
    public function schedule(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(ApplicationSchedule::class);
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
     * @param bool $includeBlank
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       bool $includeBlank = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $query = Application::select(['applications.id', 'applications.owner_id', 'role', 'apply_date', 'post_date',
            DB::raw('`companies`.`id` AS company_id'), DB::raw('`companies`.`name` AS company_name')
        ])
            ->join('companies','companies.id', 'applications.company_id')
            ->orderBy('company_name', 'asc');

        // apply filters to the query
        foreach ($filters as $column => $value) {
            if (in_array($column, ['id', 'owner_id'])) {
                $column = 'applications.' . $column;
            }
            $query->where($column, $value);
        }

        foreach ($query->get() as $application) {
            $company = !empty($application->company_name)
                ? $application->company_name
                : '?company?';
            $role = $application->role ?? '?role?';
            $date = !empty($application->apply_date)
                ? ' [applied: ' . $application->apply_date . ']'
                : (!empty($application->post_date) ? ' [applied: ' . $application->post_date . ']' : '');

            $options[$application->id] = $company . ' - ' . $role . $date;
        }

        return $options;
    }
}
