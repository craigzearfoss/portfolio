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
        'enrollment_month',
        'enrollment_year',
        'graduated',
        'graduation_month',
        'graduation_year',
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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'degree_type_id', 'major', 'minor', 'school_id',
        'featured', 'summary', 'enrollment_year', 'enrollment_month', 'graduated', 'graduation_year',
        'graduation_month', 'currently_enrolled', 'summary', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'graduation_date', 'desc' ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [
            'degree_type_name',
            'enrollment_date',
            'graduation_date',
            'school_name',
        ];
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

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
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
            ->when(!empty($filters['enrollment_month']), function ($query) use ($filters) {
                $query->where($this->table . '.enrollment_month', '=', intval($filters['enrollment_month']));
            })
            ->when(!empty($filters['enrollment_year']), function ($query) use ($filters) {
                $query->where($this->table . '.enrollment_year', '=', intval($filters['enrollment_year']));
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['graduated']), function ($query) use ($filters) {
                $query->where($this->table . '.graduated', '=', intval($filters['graduated']));
            })
            ->when(!empty($filters['graduation_month']), function ($query) use ($filters) {
                $query->where($this->table . '.graduation_month', '=', intval($filters['graduation_month']));
            })
            ->when(!empty($filters['graduation_year']), function ($query) use ($filters) {
                $query->where($this->table . '.graduation_year', '=', intval($filters['graduation_year']));
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

        $query->join( dbName('portfolio_db') . '.schools', 'schools.id', '=', $this->table . '.school_id');
        $query->join( dbName('portfolio_db') . '.degree_types', 'degree_types.id', '=', $this->table . '.degree_type_id');

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // join to owner
        $query->join( dbName('system_db') . '.admins', 'admins.id', '=', $this->table . '.owner_id');
        $query->select([
            DB::raw($this->table . '.*'),
            DB::raw('schools.name as school_name'),
            DB::raw('degree_types.name as degree_type_name'),
            DB::raw('admins.name AS `owner_name`'),
            DB::raw('admins.username AS `owner_username`'),
            DB::raw('admins.email AS `owner_email`'),
        ]);
        /*
        $query = $this->addJoinToAdminTable($query,
            portfolio_db,
             [
                DB::raw('`schools`.`name` as school_name'),
                DB::raw('`degree_types`.`name` as degree_type_name') ,
            ]
        );
*/

        // add order by clause
        if (explode('|', $sort ?? '')[0] == 'enrollment_date') {
            $query->orderBy('enrollment_year', 'desc');
            $query->orderBy('enrollment_month', 'desc');
        } elseif (explode('|', $sort ?? '')[0] == 'graduation_date') {
            $query->orderBy('graduation_year', 'desc');
            $query->orderBy('graduation_month', 'desc');
        } else {
            //dd(explode('|', $sort ?? '')[0]);
            //$query->ddRawSql();
            $query = $this->addOrderBy($query, $sort);
            if (explode('|', $sort ?? '') != 'owner_username') {
                $query->orderBy('owner_username');
            }
        }

        return $query;
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
