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
class RecipeStep extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'personal_db';

    /**
     * @var string
     */
    protected $table = 'recipe_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'recipe_id',
        'step',
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
        'recipe_name',
        'recipe_author',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'recipe_id', 'step', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'recipe_name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'all' => [
            'created_at|desc'    => 'datetime created',
            'updated_at|desc'    => 'datetime updated',
            'is_demo|desc'       => 'demo',
            'is_disabled|desc'   => 'disabled',
            'id|asc'             => 'id',
            'owner_id|asc'       => 'owner id',
            'owner_name|asc'     => 'owner name',
            'owner_username|asc' => 'owner username',
            'is_public|desc'     => 'public',
            'is_readonly|desc'   => 'read-only',
            'recipe_name|asc'    => 'recipe',
            'is_root|desc'       => 'root',
            'sequence|asc'       => 'sequence',
        ],
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

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->select(
                DB::raw(dbName($this->connection) . '.' . $this->table . '.*')
            )->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['recipe_id']), function ($query) use ($filters) {
                $query->where($this->table . '.recipe_id', '=', intval($filters['recipe_id']));
            })
            ->when(!empty($filters['step']), function ($query) use ($filters) {
                $query->where($this->table . '.step', '=', intval($filters['step']));
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // join to recipes table
        $query->join( dbName('personal_db') . '.recipes', 'recipes.id', '=', $this->table . '.recipe_id')
            ->addSelect(DB::raw(dbName($this->connection) . '.recipes.name AS recipe_name'));

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the recipe step.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the personal recipe that owns the recipe step.
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
