<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DictionaryFrameworkDictionaryLanguage extends Pivot
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_framework_dictionary_language';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'dictionary_framework_id',
        'dictionary_language_id',
    ];
}
