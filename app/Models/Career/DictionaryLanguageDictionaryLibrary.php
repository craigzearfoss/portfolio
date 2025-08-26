<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DictionaryLanguageDictionaryLibrary extends Pivot
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_language_dictionary_library';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'dictionary_language_id',
        'dictionary_library_id',
    ];
}
