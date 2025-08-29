<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FrameworkStack extends Pivot
{
    protected $connection = 'dictionary_db';

    protected $table = 'framework_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'framework_id',
        'stack_id',
    ];
}
