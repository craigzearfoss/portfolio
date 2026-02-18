<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class EmploymentStatus extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'employment_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the system admins for the employment status.
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'employment_status_id')
            ->orderBy('name');
    }
}
