<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use App\Models\Career\Communication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunicationType extends Model
{
    use SearchableModelTrait;

    protected $connection = 'career_db';

    protected $table = 'job_duration_types';

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
    const SEARCH_COLUMNS = ['id', 'name'];
    const SEARCH_ORDER_BY = ['name', 'id'];

    /**
     * Get the applications for the job schedule.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'communication_type_id')
            ->orderBy('sequence', 'asc');
    }
}
