<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DictionaryServerDictionaryStack extends Pivot
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_server_dictionary_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'dictionary_server_id',
        'dictionary_stack_id',
    ];
}
