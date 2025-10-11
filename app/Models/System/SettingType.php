<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class SettingType extends Model
{
    use SearchableModelTrait;

    protected $connection = 'core_db';

    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'name', 'description'];
    const SEARCH_ORDER_BY = ['name', 'asc'];
}
