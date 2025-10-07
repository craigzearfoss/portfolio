<?php

namespace App\Models\Portfolio;

use App\Models\Country;
use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\State;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

        static::addGlobalScope(new AdminGlobalScope());
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
        return $this->hasMany(JobCoworker::class);
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
        return $this->hasMany(JobTask::class);
    }

    /**
     * Returns an array of options for a select list for companies.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function companyListOptions(array $filters = [],
                                              bool $includeBlank = false,
                                              bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        foreach (Job::select('id', 'company')->orderBy('company', 'asc')->get() as $job) {
            $options[$nameAsKey ? $job->company : $job->id] = $job->company;
        }

        return $options;
    }

    /**
     * Returns an array of options for a job select list.
     *
     * @param array $filters
     * @param string $valueColumn
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther
     * @param array $orderBy
     * @return array
     * @throws \Exception
     */
    public static function listOptions(array  $filters = [],
                                       string $valueColumn = 'id',
                                       string $labelColumn = 'name',
                                       bool   $includeBlank = false,
                                       bool   $includeOther = false,
                                       array  $orderBy = ['company', 'asc']): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $selectColumns = self::SEARCH_COLUMNS;
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        $query = self::select($selectColumns)->orderBy($sortColumn, $sortDir);

        // Apply filters to the query.
        foreach ($filters as $col => $value) {
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
                $label = $row->name . (!empty($row->role) ? ' - ' . $row->role : '');
            } else {
                $label = $row->{$labelColumn};
            }
            $options[$row->{$valueColumn}] = $label;
        }

        return $options;
    }
}
