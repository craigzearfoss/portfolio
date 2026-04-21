<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'sequence', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'all' => [
            'id|asc'       => 'id',
            'name|asc'     => 'name',
            'sequence|asc' => 'sequence',
        ]
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the career applications for the job communication type.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'communication_type_id')
            ->orderBy('sequence');
    }
}
