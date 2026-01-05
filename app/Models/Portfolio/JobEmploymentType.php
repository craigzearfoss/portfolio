<?php

namespace App\Models\Portfolio;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobEmploymentType extends Model
{
    use SearchableModelTrait;

    protected $connection = 'portfolio_db';

    protected $table = 'job_employment_types';

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
     * Get the portfolio jobs for the job employment type.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Job::class, 'job_employment_type_id')
            ->orderBy('start_date', 'desc');
    }
}
