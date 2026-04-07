<?php

namespace App\Models\Career;

use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\RecruiterFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Recruiter extends Model
{
    /** @use HasFactory<RecruiterFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'recruiters';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'postings_url',
        'local',
        'regional',
        'national',
        'international',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'phone',
        'phone_label',
        'alt_phone',
        'alt_phone_label',
        'email',
        'email_label',
        'alt_email',
        'alt_email_label',
        'link',
        'link_name',
        'description',
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
    const array SEARCH_COLUMNS = [ 'id', 'name', 'postings_url', 'local', 'regional', 'national', 'international',
        'street', 'street2', 'city', 'state_id', 'zip', 'country_id', 'phone', 'phone_label', 'alt_phone',
        'alt_phone_label', 'email', 'email_label', 'alt_email', 'alt_email_label', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo', 'sequence' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     *
     */
    const array COVERAGE_AREAS = [
        'local',
        'regional',
        'national',
        'international',
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [
            'state_name'
        ];
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param string|null $sort
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
            ->when(!empty($filters['coverage_area']), function ($query) use ($filters) {
                if (in_array($filters['coverage_area'], self::COVERAGE_AREAS)) {
                    $query->where($this->table . '.'.$filters['coverage_area'], '=', true);
                } else {
                    throw new Exception('Invalid audio_type "' . $filters['audio_type'] . '" specified.'
                        . ' Valid coverage areas are "' . implode('", "', self::COVERAGE_AREAS) . '".');
                }
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where($this->table . '.city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where($this->table . '.country_id', '=', intval($filters['country_id']));
            })
            ->when(!empty($filters['international']), function ($query) use ($filters) {
                $query->where($this->table . '.international', '=', true);
            })
            ->when(!empty($filters['local']), function ($query) use ($filters) {
                $query->where($this->table . '.local', '=', true);
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['national']), function ($query) use ($filters) {
                $query->where($this->table . '.national', '=', true);
            })
            ->when(!empty($filters['regional']), function ($query) use ($filters) {
                $query->where($this->table . '.regional', '=', true);
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where($this->table . '.state_id', '=', intval($filters['state_id']));
            });

        $query->join( dbName('system_db') . '.states', 'states.id', '=', $this->table . '.state_id');

        $query->select([
            DB::raw('recruiters.*'),
            DB::raw('states.code AS `state_code`'),
            DB::raw('states.name AS `state_name`')
        ] );

        // add additional filters
        $query = $this->appendPhoneFilters($query, $filters);
        $query = $this->appendEmailFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system country that owns the recruiter.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the system state that owns the recruiter.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the coverage areas for the recruiter (international, national, regional, local).
     */
    protected function coverageAreas(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getCoverageAreas()
        );
    }

    /**
     * Return an array of coverage areas for the recruiter (international, national, regional, local).
     *
     * @return array
     */
    protected function getCoverageAreas(): array
    {
        $coverageAreas = [];
        if (!empty($this->international)) $coverageAreas[] = 'international';
        if (!empty($this->national)) $coverageAreas[] = 'national';
        if (!empty($this->regional)) $coverageAreas[] = 'regional';
        if (!empty($this->local)) $coverageAreas[] = 'local';

        return $coverageAreas;
    }

    /**
     * Get the career job search log entries for the cover letter.
     */
    public function jobSearchLogEntries(): HasMany
    {
        return $this->hasMany(JobSearchLog::class, 'application_id')
            ->orderBy('time_logged', 'desc');
    }
}
