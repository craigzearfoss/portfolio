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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name', 'setting_type_id', 'value'];

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
            ->when(!empty($filters['setting_type_id']), function ($query) use ($filters) {
                $query->where('setting_type_id', '=', intval($filters['setting_type_id']));
            })
            ->when(!empty($filters['value']), function ($query) use ($filters) {
                $query->where('value', 'like', '%' . $filters['value'] . '%');
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
        if (!$setting = new ResourceSetting()->where('name', $name)->first()) {

            $value = null;

        } else {

            switch ($setting->type['name']) {
                case 'array':
                    $value = json_decode($setting['value'], true);
                    break;
                case 'bool':
                    $value = boolval($setting['value']);
                    break;
                case 'float':
                    $value = floatval($setting['value']);
                    break;
                case 'int':
                    $value = intval($setting['value']);
                    break;
                default:
                    $value = $setting['value'];
                    break;
            }
        }

        return $value;
    }
}
