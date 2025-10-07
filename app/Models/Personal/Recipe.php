<?php

namespace App\Models\Personal;

use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'personal_db';

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
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     *
     */
    const TYPES = [
        'main',
        'side',
        'dessert',
        'appetizer',
        'beverage',
    ];

    /**
     *
     */
    const MEALS = [
        'breakfast',
        'lunch',
        'dinner',
        'snack',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'featured', 'author', 'main', 'side', 'dessert', 'appetizer',
        'beverage', 'breakfast', 'lunch', 'dinner', 'snack', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the recipe.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio recipe ingredients for the recipe.
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class)->orderBy('sequence', 'asc');
    }

    /**
     * Get the portfolio recipe steps for the recipe.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(RecipeStep::class)->orderBy('step', 'asc');
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
     * Returns an array of all meals available for recipes.
     *
     * @return string[]
     */
    public static function allMeals(): array
    {
        return self::MEALS;
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
}
