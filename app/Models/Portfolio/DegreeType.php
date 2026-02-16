<?php

namespace App\Models\Portfolio;

use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 * @mixin Builder
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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name'];

    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the portfolio educations for the degree type.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'degree_type_id');
    }
}
