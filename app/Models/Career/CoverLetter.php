<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\CoverLetterFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class CoverLetter extends Model
{
    /** @use HasFactory<CoverLetterFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'cover_letters';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'name',
        'slug',
        'cover_letter_date',
        'filepath',
        'content',
        'notes',
        'link',
        'link_name',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'application_id', 'name', 'cover_letter_date', 'filepath',
        'content', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [];
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
     * Generates the name for a cover letter from the application.
     *
     * @param int $applicationId
     * @return string
     */
    public static function getName(int $applicationId): string
    {
        if (!$application = Application::query()->find($applicationId)) {
            $name = 'dummy';
            // the validation will fail because there is no application id so just put anything in the name field
        } else {
            if ($application['company']['name']) {
                $name = !empty($application['role'])
                    ? $application['company']['name'] . ' - ' . $application['role']
                    : $application['company']['name'];
            } elseif(!empty($application['role'])) {
                $name = $application['role'];
            } else {
                $name = 'UNNAMED';
            }

            if (!empty($application['apply_date'])) {
                $name .= ' [' . $application['apply_date'] . ']';
            }
        }

        return $name;
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
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

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['application_id']), function ($query) use ($filters) {
                $query->where($this->table . '.application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['company_id']), function ($query) use ($filters) {
                $query->where('company_id', '=', intval($filters['company_id']));
            })
            ->when(!empty($filters['company_name']), function ($query) use ($filters) {
                $query->where('companies.name', '=', 'like', '%' . $filters['company_name'] . '%');
            })
            ->when(!empty($filters['content']), function ($query) use ($filters) {
                $query->where($this->table . '.content', 'like', '%' . $filters['content'] . '%');
            })
            ->when(!empty($filters['cover_letter_date']), function ($query) use ($filters) {
                $query->where($this->table . '.cover_letter_date', '=', $filters['cover_letter_date']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['filepath']), function ($query) use ($filters) {
                $query->where($this->table . '.filepath', 'like', '%' . $filters['filepath'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            });

        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        $query->join('applications', 'applications.id', '=', $this->table . '.application_id');
        $query->join('companies', 'companies.id', '=', 'applications.company_id');
        $query->select([
            DB::raw($this->table . '.*'),
            DB::raw('applications.company_id as company_id'),
            DB::raw('companies.name as company_name'),
        ]);

        // add order by clause
        $query = $this->addOrderBy($query, $sort);
        if (explode('|', $sort ?? '') != 'owner_username') {
            $query->orderBy('owner_username');
        }

        return $query;
    }

    /**
     * Get the system owner of the cover letter.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application that owns the career over letter.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Calculate the name of the application.
     *
     * @return string
     */
    protected function calculateName():string
    {
        $company = $this->application->company['name'];
        $role = $this->application['role'] ?? '?role?';
        $date = !empty($this->application['apply_date'])
            ? ' [applied: ' . $this->application['apply_date'] . ']'
            : (!empty($this->application['post_date']) ? ' [applied: ' . $this->application['apply_date'] . ']' : '');

        return $company . ' - ' . $role . $date;
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
     * Get the career job search log entries for the cover letter.
     */
    public function jobSearchLogEntries(): HasMany
    {
        return $this->hasMany(JobSearchLog::class, 'application_id')
            ->orderBy('time_logged', 'desc');
    }
}
