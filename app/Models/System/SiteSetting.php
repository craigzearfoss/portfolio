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
}
