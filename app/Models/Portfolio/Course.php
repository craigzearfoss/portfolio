<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\CourseFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'featured',
        'summary',
        'course_year',
        'completed',
        'completion_date',
        'duration_hours',
        'academy_id',
        'school',
        'instructor',
        'sponsor',
        'certificate_url',
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email',
        'academy_name'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'featured', 'summary', 'course_year', 'completed',
        'completion_date', 'duration_hours', 'academy_id', 'school', 'instructor', 'sponsor', 'certificate_url',
        'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo'.
        'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'academy_name|asc'     => 'academy',
        'completion_date|desc' => 'completion date',
        'created_at|desc'      => 'datetime created',
        'updated_at|desc'      => 'datetime updated',
        'is_demo|desc'         => 'demo',
        'is_disabled|desc'     => 'disabled',
        'featured|desc'        => 'featured',
        'id|asc'               => 'id',
        'instructor|asc'       => 'instructor',
        'name|asc'             => 'name',
        'owner_id|asc'         => 'owner id',
        'owner_name|asc'       => 'owner name',
        'owner_username|asc'   => 'owner username',
        'is_public|desc'       => 'public',
        'is_readonly|desc'     => 'read-only',
        'is_root|desc'         => 'root',
        'sequence|asc'         => 'sequence',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'academy_name', 'completion_date', 'is_disabled', 'instructor', 'name', 'is_public', 'course_year', ],
        'guest' => [ 'academy_name', 'completion_date', 'instructor', 'name', 'course_year', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
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
            ->when(!empty($filters['academy_id']), function ($query) use ($filters) {
                $query->where($this->table . '.academy_id', '=', intval($filters['academy_id']));
            })
            ->when(!empty($filters['academy_name']), function ($query) use ($filters) {
                $query->where('academies.name', 'like', '%' . $filters['academy_name'] . '%');
            })
            ->when(!empty($filters['completed']), function ($query) use ($filters) {
                $query->where($this->table . '.completed', '=', true);
            })
            ->when(!empty($filters['completion_date']), function ($query) use ($filters) {
                $query->where($this->table . '.completion_date', '=', $filters['completion_date']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['duration_hours']), function ($query) use ($filters) {
                $query->where($this->table . '.duration_hours', '>=', floatval($filters['duration_hours']));
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['instructor']), function ($query) use ($filters) {
                $query->where($this->table . '.instructor', 'like', '%' . $filters['instructor'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['school']), function ($query) use ($filters) {
                $query->where($this->table . '.school', 'like', '%' . $filters['school'] . '%');
            })
            ->when(!empty($filters['sponsor']), function ($query) use ($filters) {
                $query->where($this->table . '.sponsor', 'like', '%' . $filters['sponsor'] . '%');
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['course_year']), function ($query) use ($filters) {
                $query->where($this->table . '.course_year', '=', $filters['course_year']);
            });

        // join to academies table
        $query->join( dbName('portfolio_db') . '.academies', 'academies.id', '=', $this->table . '.academy_id')
            ->addSelect(DB::Raw('academies.name as academy_name'));

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        $query = $this->addOrderBy($query, $sort);

        return $query;
    }

    /**
     * Get the system owner of the course.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio academy that owns the course.
     */
    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class, 'academy_id');
    }
}
