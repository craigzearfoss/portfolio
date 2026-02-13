<?php

namespace App\Models\Personal;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use SearchableModelTrait;

    protected $connection = 'personal_db';

    protected $table = 'units';

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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name', 'abbreviation', 'system'];
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the personal recipe ingredients for the unit.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class, 'unit_id');
    }
}
