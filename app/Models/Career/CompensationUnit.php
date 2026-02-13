<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompensationUnit extends Model
{
    use SearchableModelTrait;

    protected $connection = 'career_db';

    protected $table = 'compensation_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name', 'abbreviation'];
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the career applications for the application compensation unit.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'compensation_unit_id')
            ->orderBy('post_date', 'desc');
    }
}
