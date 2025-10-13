<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use SearchableModelTrait;

    protected $connection = 'core_db';

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
    const SEARCH_COLUMNS = ['id', 'name', 'setting_type_id', 'value'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Returns the value of the setting for the specified setting or null if not found.
     *
     * @param string $name
     * @return mixed
     */
    public static function getSetting(string $name):mixed
    {
        if (!$setting = ResourceSetting::where('name', $name)->first()) {

            $value = null;

        } else {

            switch ($setting->type['name']) {
                case 'array':
                    $value = json_decode($setting['value'], true);
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
