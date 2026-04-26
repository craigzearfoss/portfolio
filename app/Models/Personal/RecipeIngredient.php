<?php

namespace App\Models\Personal;

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
class RecipeIngredient extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'personal_db';

    /**
     * @var string
     */
    protected $table = 'recipe_ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'recipe_id',
        'ingredient_id',
        'amount',
        'unit_id',
        'qualifier',
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
        'owner_name', 'owner_username', 'owner_email', 'recipe_name', 'recipe_author', 'ingredient_name',
        'ingredient_name',
        'recipe_name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'recipe_id', 'ingredient_id', 'amount', 'unit_id', 'qualifier',
        'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at',
        'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'ingredient_name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc'     => 'datetime created',
        'updated_at|desc'     => 'datetime updated',
        'is_demo|desc'        => 'demo',
        'is_disabled|desc'    => 'disabled',
        'id|asc'              => 'id',
        'ingredient_name|asc' => 'ingredient',
        'owner_id|asc'        => 'owner id',
        'owner_name|asc'      => 'owner name',
        'owner_username|asc'  => 'owner username',
        'is_public|desc'      => 'public',
        'is_readonly|desc'    => 'read-only',
        'recipe_name|asc'     => 'recipe',
        'is_root|desc'        => 'root',
        'sequence|asc'        => 'sequence',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'amount', 'is_disabled', 'name', 'recipe_name', 'is_public', 'unit', ],
        'guest' => [ 'amount', 'name', 'recipe_name', 'unit', ],
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

        $query = $this->getSearchQuery($filters, $owner)
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['ingredient_id']), function ($query) use ($filters) {
                $query->where($this->table . '.ingredient_id', '=', intval($filters['ingredient_id']));
            })
            ->when(!empty($filters['ingredient_name']), function ($query) use ($filters) {
                $query->where('ingredients.name', 'like', '%' . $filters['ingredient_name'] . '%');
            })
            ->when(!empty($filters['recipe_id']), function ($query) use ($filters) {
                $query->where($this->table . '.recipe_id', '=', intval($filters['recipe_id']));
            })
            ->when(!empty($filters['recipe_name']), function ($query) use ($filters) {
                $query->where('recipes.name', 'like', '%' . $filters['recipe_name'] . '%');
            })
            ->when(!empty($filters['unit_id']), function ($query) use ($filters) {
                $query->where($this->table . '.unit_id', '=', intval($filters['unit_id']));
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // join to recipes table
        $query->join( dbName('personal_db') . '.recipes', 'recipes.id', '=', $this->table . '.recipe_id')
            ->addSelect(DB::raw(dbName($this->connection) . '.recipes.name AS recipe_name'));

        // join to ingredients table
        $query->join( dbName('personal_db') . '.ingredients', 'ingredients.id', '=', $this->table . '.ingredient_id')
            ->addSelect(DB::raw(dbName($this->connection) . '.ingredients.name AS ingredient_name'));

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the recipe ingredient.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the personal ingredient that owns the recipe ingredient.
     */
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    /**
     * Get the personal recipe that owns the recipe ingredient.
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    /**
     * Get the personal unit that owns the recipe ingredient.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
