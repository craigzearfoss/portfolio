<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class SiteSetting extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'site_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'setting_type_id',
        'value',
        'description',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'setting_type_id', 'value', 'created_at', 'updated_at' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc'       => 'datetime created',
        'updated_at|desc'       => 'datetime updated',
        'id|asc'                => 'id',
        'name|asc'              => 'name',
        'setting_type_name|asc' => 'setting type',
        'value|asc'             => 'value',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'id', 'name', 'setting_type_name', 'value' ],
        'guest' => [ 'id', 'name', 'setting_type_name', 'value' ],
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

        return $this->getSearchQuery($filters, false)
            ->when(!empty($filters['setting_type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.setting_type_id', '=', intval($filters['setting_type_id']));
            })
            ->when(!empty($filters['value']), function ($query) use ($filters) {
                $query->where($this->table . '.value', 'like', '%' . $filters['value'] . '%');
            });
    }

    /**
     * Returns the value of the setting for the specified setting or null if not found.
     *
     * @param string $name
     * @return mixed
     */
    public static function getSetting(string $name):mixed
    {
        if (!$setting = new ResourceSetting()->newQuery()->where('name', '=', $name)->first()) {

            $value = null;

        } else {

            $value = match ($setting->type['name']) {
                'array' => json_decode($setting['value'], true),
                'bool'  => boolval($setting['value']),
                'float' => floatval($setting['value']),
                'int'   => intval($setting['value']),
                default => $setting['value'],
            };
        }

        return $value;
    }
}
