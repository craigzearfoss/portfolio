<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Portfolio\RecipeIngredient;
use App\Models\Portfolio\RecipeStep;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\RecipeFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'recipes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'professional',
        'personal',
        'featured',
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
        'admin_id',
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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the admin who owns the portfolio recipe.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the portfolio recipe ingredients for the portfolio recipe.
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class)->orderBy('sequence', 'asc');
    }

    /**
     * Get the portfolio recipe steps for the portfolio recipe.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(RecipeStep::class)->orderBy('step', 'asc');
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            if ($nameAsKey) {
                $options = [ '' => '' ];
            } else {
                $options = [ 0 => '' ];
            }
        }

        foreach (Recipe::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
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
