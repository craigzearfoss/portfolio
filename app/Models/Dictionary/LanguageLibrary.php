<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LanguageLibrary extends Pivot
{
    protected $connection = 'dictionary_db';

    protected $table = 'language_library';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'language_id',
        'library_id',
    ];
}
