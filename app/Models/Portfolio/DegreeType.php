<?php

namespace App\Models\Portfolio;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class DegreeType extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    protected $table = 'degree_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'all' => [
            'id|asc'   => 'id',
            'name|asc' => 'name',
        ]
    ];

    /**
     * Get the portfolio educations for the degree type.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'degree_type_id');
    }

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }
}
