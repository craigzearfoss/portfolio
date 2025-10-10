<?php

namespace App\Models\Career;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class ApplicationSkill extends Model
{
    use SearchableModelTrait;

    protected $connection = 'career_db';

    protected $table = 'application_skills';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'name',
        'category_id',
        'dictionary_term_id',
        'level',
        'start_year',
        'end_year',
        'years',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['owner_id', 'name', 'resource_id', 'model_class', 'model_item_id', 'category_id',
        'dictionary_term_id', 'level', 'start_year', 'end_year', 'years'];
    const SEARCH_ORDER_BY = ['name', 'asc'];
}
