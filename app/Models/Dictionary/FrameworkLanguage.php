<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 *
 */
class FrameworkLanguage extends Pivot
{
    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
    protected $table = 'framework_language';

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
        'framework_id',
        'language_id',
    ];
}
