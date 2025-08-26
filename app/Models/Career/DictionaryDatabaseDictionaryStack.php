<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DictionaryDatabaseDictionaryStack extends Pivot
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_database_dictionary_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'dictionary_database_id',
        'dictionary_stack_id',
    ];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['dictionary_stacks', 'dictionary_databases'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stack()
    {
        return $this->belongsTo('App\Models\Career\DictionaryStack', 'dictionary_stack_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function database()
    {
        return $this->belongsTo('App\Models\Career\DictionaryDatabase', 'dictionary_database_id');
    }
}
