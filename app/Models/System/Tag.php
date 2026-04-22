<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Tag extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'tags';

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
        'dictionary_term_id',
        'dictionary_category_id',
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
    const array SEARCH_COLUMNS = [ 'owner_id', 'name', 'resource_id', 'model_class', 'model_item_id',
        'dictionary_term_id', 'dictionary_category_id' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'model_class|asc'            => 'class',
        'model_class_item_id|asc'    => 'class item id',
        //'dictionary_category|asc'    => 'dictionary category',
        //'dictionary_category_id|asc' => 'dictionary category id',
        //'dictionary_term|asc'        => 'dictionary term',
        //'dictionary_term_id|asc'     => 'dictionary term id',
        'id|asc'                     => 'id',
        'name|asc'                   => 'name',
        'owner_username|asc'         => 'owner',
        'owner_id|asc'               => 'owner id',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'class', 'model_class_item_id', 'id', 'name' ],
        'guest' => [ 'class', 'model_class_item_id', 'id', 'name' ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param string|null $sort - column for sort order, append "|asc" or "|desc" to specify direction
     * @param Admin|Owner|null $owner
     * @param User|null $user
     * @return Builder
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['admin_id']);
            }
            $filters['admin_id'] = $owner->id;
        }

        return new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where($this->table . '.dictionary_category_id', '=', intval($filters['dictionary_category_id']));
            })
            ->when(!empty($filters['dictionary_term_id']), function ($query) use ($filters) {
                $query->where($this->table . '.dictionary_term_id', '=', intval($filters['dictionary_term_id']));
            })
            ->when(!empty($filters['model_class']), function ($query) use ($filters) {
                $query->where($this->table . '.model_class', 'like', '%' . $filters['model_class'] . '%');
            })
            ->when(!empty($filters['model_item_id']), function ($query) use ($filters) {
                $query->where($this->table . '.model_item_id', '=', intval($filters['model_item_id']));
            })
            ->when(!empty($filters['resource_id']), function ($query) use ($filters) {
                $query->where($this->table . '.resource_id', '=', intval($filters['resource_id']));
            });
    }
}

