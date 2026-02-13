<?php

namespace App\Models\Portfolio;

use App\Models\Portfolio\Education;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DegreeType extends Model
{
    use SearchableModelTrait;

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
