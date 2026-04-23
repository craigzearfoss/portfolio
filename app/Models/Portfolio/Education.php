<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Education extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'education';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'degree_type_id',
        'major',
        'minor',
        'school_id',
        'slug',
        'featured',
        'summary',
        'enrollment_date',
        'graduated',
        'graduation_date',
        'currently_enrolled',
        'summary',
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
        'all' => [
            'owner_name', 'owner_username', 'owner_email',
            'degree_type_name',
            'enrollment_date',
            'graduation_date',
            'school_name',
        ],
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'degree_type_id', 'major', 'minor', 'school_id',
        'featured', 'summary', 'enrollment_date', 'graduated', 'graduation_date', 'currently_enrolled', 'summary',
        'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo',
        'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'graduation_date', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc'       => 'datetime created',
        'updated_at|desc'       => 'datetime updated',
        'degree_type_name|asc'  => 'degree',
        'enrollment_date|desc'  => 'enrollment date',
        'graduation_date|desc'  => 'graduation date',
        'id|asc'                => 'id',
        'major|asc'             => 'major',
        'minor|asc'             => 'minor',
        'school_name|asc'       => 'school',
        'sequence|asc'          => 'sequence',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'degree_type_name', 'enrollment_date', 'expiration', 'graduated', 'graduation_date', 'major', 'minor', 'school_name', ],
        'guest' => [ 'degree_type_name', 'graduation_date', 'major', 'school_name', ],
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
            ->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['currently_enrolled']), function ($query) use ($filters) {
                $query->where($this->table . '.currently_enrolled', '=', intval($filters['currently_enrolled']));
            })
            ->when(!empty($filters['degree_type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.degree_type_id', '=', intval($filters['degree_type_id']));
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['enrollment_date']), function ($query) use ($filters) {
                $query->where($this->table . '.enrollment_date', '<=', $filters['enrollment_date']);
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['graduated']), function ($query) use ($filters) {
                $query->where($this->table . '.graduated', '=', intval($filters['graduated']));
            })
            ->when(!empty($filters['graduation_date']), function ($query) use ($filters) {
                $query->where($this->table . '.graduation_date', '<=', $filters['graduation_date']);
            })
            ->when(!empty($filters['major']), function ($query) use ($filters) {
                $query->where($this->table . '.major', 'like', '%' . $filters['major'] . '%');
            })
            ->when(!empty($filters['minor']), function ($query) use ($filters) {
                $query->where($this->table . '.minor', 'like', '%' . $filters['minor'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['school_id']), function ($query) use ($filters) {
                $query->where($this->table . '.school_id', '=', intval($filters['school_id']));
            })
            ->when(!empty($filters['school_name']), function ($query) use ($filters) {
                $query->where('schools.name', 'like', '%' . $filters['school_name'] . '%');
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            });

        // join to schools table
        $query->join( dbName('portfolio_db') . '.schools', 'schools.id', '=', $this->table . '.school_id')
            ->addSelect(DB::Raw('schools.name as school_name'));

        // join to degree types
        $query->join( dbName('portfolio_db') . '.degree_types', 'degree_types.id', '=', $this->table . '.degree_type_id')
            ->addSelect(DB::Raw('degree_types.name as degree_type_name'));

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the education.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio degree type that owner the education.
     */
    public function degreeType(): BelongsTo
    {
        return $this->belongsTo(DegreeType::class, 'degree_type_id');
    }

    /**
     * Get the portfolio school that owns the education.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
