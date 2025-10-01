<?php

namespace App\Models\Personal;

use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RecipeIngredient extends Model
{
    use SoftDeletes;

    protected $connection = 'personal_db';

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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the personal recipe ingredient.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio recipe that owns the personal recipe ingredient.
     */
    public function recipe(): BelongsTo
    {
        return $this->setConnection('personal_db')->belongsTo(Recipe::class, 'recipe_id');
    }

    /**
     * Get the portfolio ingredient that owns the personal recipe ingredient.
     */
    public function ingredient(): BelongsTo
    {
        return $this->setConnection('personal_db')->belongsTo(Ingredient::class, 'ingredient_id');
    }

    /**
     * Get the portfolio unit that owns the personal recipe ingredient.
     */
    public function unit(): BelongsTo
    {
        return $this->setConnection('personal_db')->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Returns an array of options for a recipe ingredient select list.
     * Note that there might will be recipe ingredients.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey   - Do not use this because there are likely to be duplicated names.
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       bool $includeBlank = false,
                                       bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $query = self::select('*', DB::raw('`ingredients`.`name` as ingredient_name'))
            ->join('ingredients', 'ingredients.id', '=', 'recipe_ingredients.ingredient_id')
            ->orderBy('ingredient_name', 'asc');

        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $recipeIngredient) {
            $key = $nameAsKey ? $recipeIngredient->ingredient_name : $recipeIngredient->id;
            $options[$key] = $recipeIngredient->ingredient_name;
        }

        return $options;
    }
}
