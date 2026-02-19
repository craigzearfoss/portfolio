<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminEmail extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'admin_emails';

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
        'public',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'owner_id', 'email', 'label', 'description', 'notes', 'public' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['email', 'asc'];

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->when(!empty($filters['owner_id']), function ($query) use ($filters) {
            $query->where('owner_id', '=', intval($filters['owner_id']));
        })
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $query->where('email', 'like', '%' . $filters['email'] . '%');
            })->when(isset($filters['public']), function ($query) use ($filters) {
                $query->where('public', '=', boolval(['public']));
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system owner of the email.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }
}
