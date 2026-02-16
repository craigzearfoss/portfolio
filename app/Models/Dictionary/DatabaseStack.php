<?php

namespace App\Models\Dictionary;

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
    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
    protected $table = 'database_stack';

    /**
     * @var bool
     */
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
    public function stack(): BelongsTo
    {
        return $this->belongsTo(Stack::class, 'stack_id');
    }

    /**
     * Get the dictionary database that owns the database stack.
     * *
     * @return BelongsTo
     */
    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class, 'database_id');
    }
}
