<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Portfolio\Ingredient;
use App\Models\Portfolio\Recipe;
use App\Models\Portfolio\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeIngredient extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\RecipeIngredientFactory> */
    use HasFactory;

    protected $connection = 'portfolio_db';

    protected $table = 'recipe_ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'recipe_id',
        'ingredient_id',
        'amount',
        'unit_id',
        'description',
        'image',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];


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
            $options = [ '' => '' ];
        }

        foreach (RecipeIngredient::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }

    /**
     * Get the admin who owns the recipe ingredient.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the recipe that owns the recipe ingredient.
     */
    public function recipe(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Recipe::class, 'recipe_id');
    }

    /**
     * Get the ingredient that owns the recipe ingredient.
     */
    public function ingredient(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Ingredient::class, 'ingredient_id');
    }


    /**
     * Get the unit that owns the recipe ingredient.
     */
    public function unit(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Unit::class, 'unit_id');
    }
}
