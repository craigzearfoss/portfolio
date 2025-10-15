<?php

namespace App\Models\Portfolio;

use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSkill extends Model
{
    use SearchableModelTrait;

    protected $connection = 'portfolio_db';

    protected $table = 'application_skills';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'job_id',
        'name',
        'category_id',
        'dictionary_term_id',
        'level',
        'start_year',
        'end_year',
        'years',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['owner_id', 'job_id', 'name', 'category_id', 'dictionary_term_id', 'level',
        'model_item_id', 'start_year', 'end_year', 'years'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the owner of the job skill.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the job of the job skill.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
