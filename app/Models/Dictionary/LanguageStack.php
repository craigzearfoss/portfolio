<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LanguageStack extends Pivot
{
    protected $connection = 'dictionary_db';

    protected $table = 'language_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'language_id',
        'stack_id',
    ];
}
