<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class JobLocationType extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'abbreviation' ];

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
     * Get the career applications for the job location type.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_location_type_id')
            ->orderBy('post_date', 'desc');
    }
}
