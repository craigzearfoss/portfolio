<?php

namespace App\Models\Personal;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Unit extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'personal_db';

    /**
     * @var string
     */
    protected $table = 'units';

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
        'abbreviation',
        'system',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'abbreviation', 'system' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'id|asc'           => 'id',
        'name|asc'         => 'name',
        'abbreviation|asc' => 'abbreviation',
        'sequence|asc'     => 'sequence',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'abbreviation', 'name', 'sequence', ],
        'guest' => [ 'abbreviation', 'name', 'sequence', ],
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
            ->when(!empty($filters['abbreviation']), function ($query) use ($filters) {
                $query->where($this->table . '.abbreviation', 'like', '%' . $filters['abbreviation'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['system']), function ($query) use ($filters) {
                $query->where($this->table . '.system', '=', $filters['system']);
            });

        $query->select([
            DB::raw('units.*'),
        ] );

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the personal recipe ingredients for the unit.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class, 'unit_id');
    }
}
