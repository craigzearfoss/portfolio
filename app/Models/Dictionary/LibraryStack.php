<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LibraryStack extends Pivot
{
    protected $connection = 'dictionary_db';

    protected $table = 'library_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'library_id',
        'stack_id',
    ];
}
