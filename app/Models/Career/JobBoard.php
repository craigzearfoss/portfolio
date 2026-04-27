<?php

namespace App\Models\Career;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class JobBoard extends Model
{
    use SearchableModelTrait;

    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'job_boards';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'primary',
        'local',
        'regional',
        'national',
        'international',
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'primary', 'local', 'regional', 'national', 'international',
        'link', 'link_name', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc' => 'date created',
        'updated_at|desc' => 'date updated',
        'id|asc'          => 'id',
        'name|asc'        => 'name',
        'sequence|asc'    => 'sequence',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'name', ],
        'guest' => [ 'name', ],
    ];

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

        $query = $this->getSearchQuery($filters, false)
            ->when(!empty($filters['coverage_area']), function ($query) use ($filters) {
                if (in_array($filters['coverage_area'], self::COVERAGE_AREAS)) {
                    $query->where($this->table . '.'.$filters['coverage_area'], '=', true);
                } else {
                    throw new Exception('Invalid coverage_area "' . $filters['coverage_area'] . '" specified.'
                        . ' Valid coverage areas are "' . implode('", "', self::COVERAGE_AREAS) . '".');
                }
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
            ->when(!empty($filters['primary']), function ($query) use ($filters) {
                $query->where($this->table . '.primary', '=', true);
            })
            ->when(!empty($filters['regional']), function ($query) use ($filters) {
                $query->where($this->table . '.regional', '=', true);
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the career applications for the job board.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_board_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Get the coverage areas for the job board (international, national, regional, local).
     */
    protected function coverageAreas(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getCoverageAreas()
        );
    }

    /**
     * Return an array of coverage areas for the job board (international, national, regional, local).
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
}
