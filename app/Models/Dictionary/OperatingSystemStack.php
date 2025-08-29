<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OperatingSystemStack extends Pivot
{
    protected $connection = 'dictionary_db';

    protected $table = 'operating_system_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'operating_system_id',
        'stack_id',
    ];
}
