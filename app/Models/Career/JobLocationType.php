<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobLocationType extends Model
{
    use SearchableModelTrait;

    protected $connection = 'career_db';

    protected $table = 'job_location_types';

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
    const SEARCH_COLUMNS = ['id', 'name', 'abbreviation'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the career applications for the job location type.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_location_type_id')
            ->orderBy('post_date', 'desc');
    }
}
