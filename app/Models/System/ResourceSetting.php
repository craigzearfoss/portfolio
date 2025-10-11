<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class ResourceSetting extends Model
{
    use SearchableModelTrait;

    protected $connection = 'core_db';

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
}
