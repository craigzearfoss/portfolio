<?php

namespace App\Models\Career;

use App\Models\System\Admin;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobStatus extends Model
{
    use SearchableModelTrait;

    protected $connection = 'career_db';

    protected $table = 'job_statuses';

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
     * Get the career applications for the job status.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Admin::class, 'job_status_id')
            ->orderBy('username');
    }
}
