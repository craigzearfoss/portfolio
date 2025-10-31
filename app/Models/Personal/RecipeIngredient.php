<?php

namespace App\Models\Personal;

use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeIngredient extends Model
{
    use SearchableModelTrait, SoftDeletes;

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
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'recipe_id', 'ingredient_id', 'amount', 'unit_id', 'qualifier',
        'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['recipe_id', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the recipe ingredient.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio recipe that owns the recipe ingredient.
     */
    public function recipe(): BelongsTo
    {
        return $this->setConnection('personal_db')->belongsTo(Recipe::class, 'recipe_id');
    }

    /**
     * Get the portfolio ingredient that owns the recipe ingredient.
     */
    public function ingredient(): BelongsTo
    {
        return $this->setConnection('personal_db')->belongsTo(Ingredient::class, 'ingredient_id');
    }

    /**
     * Get the portfolio unit that owns the recipe ingredient.
     */
    public function unit(): BelongsTo
    {
        return $this->setConnection('personal_db')->belongsTo(Unit::class, 'unit_id');
    }
}
