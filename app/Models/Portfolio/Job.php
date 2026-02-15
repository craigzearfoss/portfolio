<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Models\System\ResourceSetting;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\JobFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

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
        'start_month',
        'start_year',
        'end_month',
        'end_year',
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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'company', 'role', 'featured', 'start_month', 'start_year', 'end_month',
        'job_employment_type_id', 'job_location_type_id', 'end_year', 'street', 'street2', 'city', 'state_id', 'zip',
        'country_id', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const array SEARCH_ORDER_BY = ['company', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        return self::when(isset($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['company']), function ($query) use ($filters) {
                $query->where('company', 'like', '%' . $filters['company'] . '%');
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->where('role', 'like', '%' . $filters['role'] . '%');
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(isset($filters['start_month']), function ($query) use ($filters) {
                $query->where('start_month', '=', intval($filters['start_month']));
            })
            ->when(isset($filters['start_year']), function ($query) use ($filters) {
                $query->where('start_year', '=', intval($filters['start_year']));
            })
            ->when(isset($filters['end_month']), function ($query) use ($filters) {
                $query->where('end_month', '=', intval($filters['end_month']));
            })
            ->when(isset($filters['end_year']), function ($query) use ($filters) {
                $query->where('end_year', '=', intval($filters['end_year']));
            })
            ->when(isset($filters['job_employment_type_id']), function ($query) use ($filters) {
                $query->where('job_employment_type_id', '=', intval($filters['job_employment_type_id']));
            })
            ->when(isset($filters['job_location_type_id']), function ($query) use ($filters) {
                $query->where('job_location_type_id', '=', intval($filters['job_location_type_id']));
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
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
    }

    /**
     * Get the system owner of the job.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
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
     * Calculate the name of the application.
     */
    protected function calculateName()
    {
        return $this->company . (!empty($this->role) ? ' (' . $this->role . ')' : '');
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

            if ($database = Database::where('tag', self::DATABASE_TAG)->first()) {
                if ($resource = Resource::where('database_id', $database->id)->where('table', 'jobs')->first()) {
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
