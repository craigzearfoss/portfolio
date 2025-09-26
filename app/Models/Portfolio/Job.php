<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Country;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\JobFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company',
        'slug',
        'featured',
        'role',
        'start_month',
        'start_year',
        'end_month',
        'end_year',
        'summary',
        'notes',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
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
        'admin_id',
    ];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the admin who owns the portfolio job.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the country that owns the portfolio job.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the portfolio job coworkers for the portfolio job.
     */
    public function coworkers(): HasMany
    {
        return $this->hasMany(JobCoworker::class);
    }

    /**
     * Get the state that owns the portfolio job.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the portfolio job tasks for the portfolio job.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(JobTask::class);
    }

    /**
     * Returns an array of options for a select list for companies.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function companyListOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (Job::select('id', 'company')->orderBy('company', 'asc')->get() as $job) {
            $options[$nameAsKey ? $job->company : $job->id] = $job->company;
        }

        return $options;
    }
}
