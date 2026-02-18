<?php

namespace App\Models\Career;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
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
    const array SEARCH_COLUMNS = ['id', 'name', 'primary', 'local', 'regional', 'national', 'international', 'public',
        'link', 'link_name', 'readonly', 'root', 'disabled'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(isset($filters['primary']), function ($query) use ($filters) {
                $query->where('primary', '=', boolval($filters['primary']));
            })
            ->when(isset($filters['local']), function ($query) use ($filters) {
                $query->where('local', '=', boolval($filters['local']));
            })
            ->when(isset($filters['regional']), function ($query) use ($filters) {
                $query->where('regional', '=', boolval($filters['regional']));
            })
            ->when(isset($filters['national']), function ($query) use ($filters) {
                $query->where('national', '=', boolval($filters['national']));
            })
            ->when(isset($filters['international']), function ($query) use ($filters) {
                $query->where('international', '=', boolval($filters['international']));
            });

        return $this->appendStandardFilters($query, $filters);
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
