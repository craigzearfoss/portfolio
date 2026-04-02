<?php

namespace App\Models\Personal;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
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
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'featured', 'summary', 'source',  'author', 'prep_time',
        'total_time', 'main', 'side', 'dessert', 'appetizer', 'beverage', 'breakfast', 'lunch', 'dinner', 'snack',
        'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

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
     * @throws Exception
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['appetizer']), function ($query) use ($filters) {
                $query->where($this->table . '.appetizer', '=', true);
            })
            ->when(!empty($filters['author']), function ($query) use ($filters) {
                $query->where($this->table . '.author', 'like', '%' . $filters['author'] . '%');
            })
            ->when(!empty($filters['beverage']), function ($query) use ($filters) {
                $query->where($this->table . '.beverage', '=', true);
            })
            ->when(!empty($filters['breakfast']), function ($query) use ($filters) {
                $query->where($this->table . '.breakfast', '=', true);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['dessert']), function ($query) use ($filters) {
                $query->where($this->table . '.dessert', '=', true);
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['dinner']), function ($query) use ($filters) {
                $query->where($this->table . '.dinner', '=', true);
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['lunch']), function ($query) use ($filters) {
                $query->where($this->table . '.lunch', '=', true);
            })
            ->when(!empty($filters['main']), function ($query) use ($filters) {
                $query->where($this->table . '.main', '=', true);
            })
            ->when(!empty($filters['meal']), function ($query) use ($filters) {
                if (in_array($filters['meal'], ['breakfast', 'dinner', 'lunch', 'snack'])) {
                    $query->where($filters[$this->table . '.meal'], '=', true);
                } else {
                    throw new Exception('Invalid recipe meal "' . $filters['meal'] . '" specified.'
                        . ' Valid relations are "breakfast", "dinner", "lunch", and "snack".');
                }
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['prep_time']), function ($query) use ($filters) {
                $prep_time = $filters['prep_time'];
                $query->where(function ($query) use ($prep_time) {
                    $query->where($this->table . '.prep_time', '<=', intval($prep_time))
                        ->where($this->table . '.prep_time', '>', 0)
                        ->whereNotNull($this->table . '.prep_time');
                });
            })
            ->when(!empty($filters['side']), function ($query) use ($filters) {
                $query->where($this->table . '.side', '=', true);
            })
            ->when(!empty($filters['snack']), function ($query) use ($filters) {
                $query->where($this->table . '.snack', '=', true);
            })
            ->when(!empty($filters['source']), function ($query) use ($filters) {
                $query->where($this->table . '.source', 'like', '%' . $filters['source'] . '%');
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['total_time']), function ($query) use ($filters) {
                $total_time = $filters['total_time'];
                $query->where(function ($query) use ($total_time) {
                    $query->where($this->table . '.total_time', '<=', intval($total_time))
                        ->where($this->table . '.total_time', '>', 0)
                        ->whereNotNull($this->table . '.total_time');
                });
            })
            ->when(!empty($filters['type']), function ($query) use ($filters) {
                if (in_array($filters['type'], ['appetizer', 'beverage', 'dessert', 'main', 'side'])) {
                    $query->where($this->table . '.' . $filters['type'], '=', true);
                } else {
                    throw new Exception('Invalid recipe type "' . $filters['type'] . '" specified.'
                        . ' Valid relations are "appetizer", "beverage", "dessert", "main", and "side".');
                }
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
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
