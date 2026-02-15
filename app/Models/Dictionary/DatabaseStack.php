<?php

namespace App\Models\Dictionary;

use App\Models\Dictionary\Database;
use App\Models\Dictionary\Stack;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
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
     * Get the dictionary stack that owns the database stack.
     *
     * @return BelongsTo
     */
    public function stack()
    {
        return $this->belongsTo(Stack::class, 'stack_id');
    }

    /**
     * Get the dictionary database that owns the database stack.
     * *
     * @return BelongsTo
     */
    public function database()
    {
        return $this->belongsTo(Database::class, 'database_id');
    }
}
