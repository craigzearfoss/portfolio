<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use App\Models\Career\Communication;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class CommunicationType extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'communication_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['sequence', 'asc'];

    /**
     * Get the career applications for the job communication type.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'communication_type_id')
            ->orderBy('sequence');
    }
}
