<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class ResourceSetting extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'resource_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'resource_id',
        'name',
        'setting_type_id',
        'value',
        'description',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'admin_name', 'admin_username', 'admin_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'resource_id', 'name', 'setting_type_id', 'value', 'created_at',
        'updated_at'
    ];

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
        'owner_username|asc'    => 'owner',
        'owner_id|asc'          => 'owner id',
        'resource_id|asc'       => 'resource id',
        'resource_name|asc'     => 'resource name',
        'setting_type_name|asc' => 'setting type',
        'value|asc'             => 'value',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'name', 'resource_name', 'setting_type_name', 'value' ],
        'guest' => [ 'name', 'resource_name', 'setting_type_name', 'value' ],
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

        $query = $this->getSearchQuery($filters, $owner)
            ->when(!empty($filters['resource_id']), function ($query) use ($filters) {
                $query->where($this->table . '.resource_id', '=', intval($filters['resource_id']));
            })
            ->when(!empty($filters['setting_type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.setting_type_id', '=', intval($filters['setting_type_id']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['value']), function ($query) use ($filters) {
                $query->where($this->table . '.value', 'like', '%' . $filters['value'] . '%');
            });

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Returns the value of the setting for the specified setting or null if not found.
     *
     * @param int $resource_id
     * @param string $name
     * @return mixed
     */
    public static function getSetting(int $resource_id, string $name):mixed
    {
        if (!$setting = new ResourceSetting()->where('resource_id', '=', $resource_id)
            ->where('name', $name)
            ->first()
        ) {

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

    /**
     * Get the system resource of the resource setting.
     *
     * @return BelongsTo
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    /**
     * Get the system setting type that owns the resource setting.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(SettingType::class, 'setting_type_id');
    }
}
