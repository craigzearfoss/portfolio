<?php

namespace App\Models\Personal;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Recipe extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'personal_db';

    /**
     * @var string
     */
    protected $table = 'recipes';

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
        'source',
        'author',
        'prep_time',
        'total_time',
        'main',
        'side',
        'dessert',
        'appetizer',
        'beverage',
        'breakfast',
        'lunch',
        'dinner',
        'snack',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
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
     *
     */
    const array TYPES = [
        'main',
        'side',
        'dessert',
        'appetizer',
        'beverage',
    ];

    /**
     *
     */
    const array MEALS = [
        'breakfast',
        'lunch',
        'dinner',
        'snack',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'featured', 'author', 'prep_time','total_time', 'main', 'side',
        'dessert', 'appetizer', 'beverage', 'breakfast', 'lunch', 'dinner', 'snack', 'public', 'readonly', 'root',
        'disabled', 'demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

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
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(isset($filters['source']), function ($query) use ($filters) {
                $query->where('source', '=', $filters['source']);
            })
            ->when(isset($filters['author']), function ($query) use ($filters) {
                $query->where('author', '=', $filters['author']);
            })
            ->when(isset($filters['prep_time']), function ($query) use ($filters) {
                $query->where('prep_time', '<=', intval($filters['prep_time']));
            })
            ->when(isset($filters['total_time']), function ($query) use ($filters) {
                $query->where('total_time', '<=', intval($filters['total_time']));
            })
            ->when(isset($filters['main']), function ($query) use ($filters) {
                $query->where('main', '=', boolval(['main']));
            })
            ->when(isset($filters['side']), function ($query) use ($filters) {
                $query->where('side', '=', boolval(['side']));
            })
            ->when(isset($filters['dessert']), function ($query) use ($filters) {
                $query->where('dessert', '=', boolval(['dessert']));
            })
            ->when(isset($filters['appetizer']), function ($query) use ($filters) {
                $query->where('appetizer', '=', boolval(['appetizer']));
            })
            ->when(isset($filters['beverage']), function ($query) use ($filters) {
                $query->where('beverage', '=', boolval(['beverage']));
            })
            ->when(isset($filters['breakfast']), function ($query) use ($filters) {
                $query->where('breakfast', '=', boolval(['breakfast']));
            })
            ->when(isset($filters['lunch']), function ($query) use ($filters) {
                $query->where('lunch', '=', boolval(['lunch']));
            })
            ->when(isset($filters['dinner']), function ($query) use ($filters) {
                $query->where('dinner', '=', boolval(['dinner']));
            })
            ->when(isset($filters['snack']), function ($query) use ($filters) {
                $query->where('snack', '=', boolval(['snack']));
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system owner of the recipe.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Returns an array of all types available for recipes.
     *
     * @return string[]
     */
    public static function allTypes(): array
    {
        return self::TYPES;
    }

    /**
     * Get the personal recipe ingredients for the recipe.
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id')
            ->orderBy('sequence');
    }

    /**
     * Returns an array of meals for the current recipe.
     *
     * @return array
     */
    public function meals(): array
    {
        $recipeMeals = [];
        foreach(self::MEALS as $meal) {
            if (!empty($this->{$meal})) {
                $recipeMeals[] = $meal;
            }
        }

        return $recipeMeals;
    }

    /**
     * Get the personal recipe steps for the recipe.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(RecipeStep::class, 'recipe_id')
            ->orderBy('step');
    }

    /**
     * Returns an array of types for the current recipe.
     *
     * @return array
     */
    public function types(): array
    {
        $recipeTypes = [];
        foreach(self::TYPES as $type) {
            if (!empty($this->{$type})) {
                $recipeTypes[] = $type;
            }
        }

        return $recipeTypes;
    }
}
