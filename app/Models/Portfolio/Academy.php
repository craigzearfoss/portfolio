<?php

namespace App\Models\Portfolio;

use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Academy extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'academies';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
        'public',
        'readonly',
        'root',
        'demo',
        'disabled',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name', 'slug'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the portfolio certificates for the academy.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'academy_id');
    }

    /**
     * Get the portfolio courses for the academy.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'academy_id');
    }
}
