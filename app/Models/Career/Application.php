<?php

namespace App\Models\Career;

use App\Models\Admin;
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
use App\Models\Scopes\AdminGlobalScope;
use App\Models\State;
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
        'company_id',
        'resume_id',
        'role',
        'rating',
        'active',
        'resume_id',
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
        'job_board_id',
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
        'admin_id',
    ];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the admin who owns the career application.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the career communications for the career application.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'application_id')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');
    }

    /**
     * Get the career company that owns the career application.
     */
    public function company(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Company::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career application compensation unit that owns the career application.
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
        return $this->setConnection('default_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the career cover letter for the career application.
     */
    public function coverLetter(): HasOne
    {
        return $this->setConnection('career_db')->hasOne(CoverLetter::class)
            ->orderBy('date', 'desc');
    }

    /**
     * Get the career application duration that owns the career application.
     */
    public function duration(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(ApplicationDuration::class);
    }

    /**
     * Get the career events for the career application.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'application_id')
            ->orderBy('date', 'desc');
    }

    /**
     * Get the job_board who owns the career application.
     */
    public function job_board(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(JobBoard::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career notes for the career application.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'application_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the career application office that owns the career application.
     */
    public function office(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(ApplicationOffice::class);
    }

    /**
     * Get the career resume that owns the career application.
     */
    public function resume(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Resume::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career application schedule that owns the career application.
     */
    public function schedule(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(ApplicationSchedule::class);
    }

    /**
     * Get the state that owns the career application.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Returns an array of options for a select list for applications.
     *
     * @param int | null $adminId
     * @param bool $includeBlank
     * @return array|string[]
     */
    public static function listOptions(int | null $adminId = null, bool $includeBlank = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $query = Application::select(['applications.id', 'role', 'post_date', 'applications.admin_id',
            DB::raw('companies.name AS company_name')
        ])
            ->join('companies','companies.id', 'applications.company_id')
            ->orderBy('company_name', 'asc');

        if (!empty($adminId)) {
            $query->where('applications.admin_id', $adminId);
        }

        foreach ($query->get() as $application) {
            $options[$application->id] = $application->company_name . ' - ' . $application->role
                . '  (posted: ' . $application->post_date . ')';
        }

        return $options;
    }
}
