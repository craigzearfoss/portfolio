<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Tags extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
    protected $table = 'stacks';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'resource_id',
        'model_class',
        'model_item_id',
        'dictionary_category_id',
        'dictionary_term_id',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['owner_id', 'name', 'resource_id', 'model_class', 'model_item_id', 'dictionary_category_id',
        'dictionary_term_id'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

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
                unset($filters['admin_id']);
            }
            $filters['admin_id'] = $owner->id;
        }

        return new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['resource_id']), function ($query) use ($filters) {
                $query->where('resource_id', '=', intval($filters['resource_id']));
            })
            ->when(!empty($filters['model_class']), function ($query) use ($filters) {
                $query->where('model_class', 'like', '%' . $filters['model_class'] . '%');
            })
            ->when(!empty($filters['model_item_id']), function ($query) use ($filters) {
                $query->where('model_item_id', '=', intval($filters['model_item_id']));
            })
            ->when(!empty($filters['dictionary_term_id']), function ($query) use ($filters) {
                $query->where('dictionary_term_id', '=', intval($filters['dictionary_term_id']));
            })
            ->when(!empty($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where('dictionary_category_id', '=', intval($filters['dictionary_category_id']));
            });
    }
}
