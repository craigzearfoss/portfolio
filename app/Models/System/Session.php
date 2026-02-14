<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Session extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

    protected $table = 'sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'user_id', 'admin_id', 'ip_address', 'user_agent', 'payload', 'last_activity'];
    const array SEARCH_ORDER_BY = ['last_activity', 'desc'];

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['admin_id']);
            }
            $filters['admin_id'] = $owner->id;
        }

        return self::when(isset($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['user_id']), function ($query) use ($filters) {
                $query->where('user_id', '=', intval($filters['user_id']));
            })
            ->when(!empty($filters['admin_id']), function ($query) use ($filters) {
                $query->where('admin_id', '=', intval($filters['admin_id']));
            })
            ->when(!empty($filters['ip_address']), function ($query) use ($filters) {
                $query->where('ip_address', '=', $filters['ip_address']);
            });
    }
}
