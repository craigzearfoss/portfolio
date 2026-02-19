<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPhone extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'admin_phones';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'phone',
        'label',
        'description',
        'notes',
        'public',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'owner_id', 'phone', 'label', 'description', 'notes', 'public' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['phone', 'asc'];

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['phone']), function ($query) use ($filters) {
                $query->where('phone', 'like', '%' . $filters['phone'] . '%');
            })->when(isset($filters['public']), function ($query) use ($filters) {
                $query->where('public', '=', boolval(['public']));
            });

        return $this->appendStandardFilters($query, $filters);
    }
}
