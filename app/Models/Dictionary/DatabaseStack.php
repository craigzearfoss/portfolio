<?php

namespace App\Models\Dictionary;

use App\Models\Dictionary\Database;
use App\Models\Dictionary\Stack;
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
        return $this->belongsTo(Stack::class, 'stack_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function database()
    {
        return $this->belongsTo(Database::class, 'database_id');
    }
}
