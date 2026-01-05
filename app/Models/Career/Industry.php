<?php

namespace App\Models\Career;

use App\Models\Career\Company;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    use SearchableModelTrait;

    protected $connection = 'career_db';

    protected $table = 'industries';

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
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'name', 'abbreviation'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the career companies for the industry.
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'industry_id');
    }
}
