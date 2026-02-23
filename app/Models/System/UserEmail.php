<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEmail extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'user_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'email',
        'label',
        'description',
        'notes',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'owner_id', 'email', 'label', 'description', 'notes', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'email', 'asc' ];

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
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $query->where('email', 'like', '%' . $filters['email'] . '%');
            })
            ->when(isset($filters['is_public']), function ($query) use ($filters) {
                $query->where('is_public', '=', boolval(['is_public']));
            })
            ->when(isset($filters['is_readonly']), function ($query) use ($filters) {
                $query->where('is_readonly', '=', boolval(['is_readonly']));
            })
            ->when(isset($filters['is_root']), function ($query) use ($filters) {
                $query->where('is_root', '=', boolval(['is_root']));
            })
            ->when(isset($filters['is_disabled']), function ($query) use ($filters) {
                $query->where('is_disabled', '=', boolval(['is_disabled']));
            })
            ->when(isset($filters['is_demo']), function ($query) use ($filters) {
                $query->where('is_demo', '=', boolval(['is_demo']));
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
