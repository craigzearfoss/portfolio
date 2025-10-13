<?php

namespace App\Models\System;

use App\Models\System\SettingType;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceSetting extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

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
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'resource_id', 'name', 'setting_type_id', 'value'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the resource of the resource setting.
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    /**
     * Get the type of the resource setting.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(SettingType::class, 'setting_type_id');
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
        if (!$setting = ResourceSetting::where('resource_id', $resource_id)
            ->where('name', $name)
            ->first()
        ) {

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
