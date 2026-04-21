<?php

namespace App\Models\Personal;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Unit extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'personal_db';

    /**
     * @var string
     */
    protected $table = 'units';

    /**
     * @var bool
     */
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'abbreviation', 'system' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'all' => [
            'id|asc'           => 'id',
            'name|asc'         => 'name',
            'abbreviation|asc' => 'abbreviation',
            'sequence|asc'     => 'sequence',
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
     * Get the personal recipe ingredients for the unit.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class, 'unit_id');
    }
}
