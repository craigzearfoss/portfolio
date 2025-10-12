<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AccessGlobalScope;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\JobFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

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
        'notes',
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
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'company', 'role', 'featured', 'start_month', 'start_year', 'end_month',
        'end_year', 'city', 'state_id', 'zip', 'country_id', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AccessGlobalScope());
    }

    /**
     * Get the owner of the job.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the country that owns the job.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the job coworkers for the job.
     */
    public function coworkers(): HasMany
    {
        return $this->hasMany(JobCoworker::class, 'job_id');
    }

    /**
     * Get the employment type of the job.
     */
    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(JobEmploymentType::class, 'job_employment_type_id');
    }

    /**
     * Get the location type of the job.
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
     * Get the job skills for the job.
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
     * Get the state that owns the job.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the job tasks for the job.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(JobTask::class, 'job_id');
    }
}
