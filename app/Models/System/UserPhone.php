<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPhone extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'user_phones';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'phone',
        'label',
        'description',
        'notes',
        'public',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'owner_id', 'phone', 'label', 'description', 'notes', 'public' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['phone', 'asc'];

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param User|null $user
     * @return Builder
     */
    public function searchQuery(array $filters = [], User|null $user = null): Builder
    {
        if (!empty($user)) {
            if (array_key_exists('user_id', $filters)) {
                unset($filters['user_id']);
            }
            $filters['user_id'] = $user->id;
        }

        $query = new self()->when(!empty($filters['user_id']), function ($query) use ($filters) {
            $query->where('user_id', '=', intval($filters['user_id']));
        })
            ->when(!empty($filters['phone']), function ($query) use ($filters) {
                $query->where('phone', 'like', '%' . $filters['phone'] . '%');
            })->when(isset($filters['public']), function ($query) use ($filters) {
                $query->where('public', '=', boolval(['public']));
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system user (owner) of the user email.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
