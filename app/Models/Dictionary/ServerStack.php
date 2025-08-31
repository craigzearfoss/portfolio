<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ServerStack extends Pivot
{
    protected $connection = 'dictionary_db';

    protected $table = 'server_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'server_id',
        'stack_id',
    ];
}
