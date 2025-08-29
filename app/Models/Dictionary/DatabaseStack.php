<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DatabaseStack extends Pivot
{
    protected $connection = 'dictionary_db';

    protected $table = 'database_stack';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'database_id',
        'stack_id',
    ];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['stacks', 'databases'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stack()
    {
        return $this->belongsTo('App\Models\Dictionary\Stack', 'stack_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function database()
    {
        return $this->belongsTo('App\Models\Dictionary\Database', 'database_id');
    }
}
