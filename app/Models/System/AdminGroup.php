<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class AdminGroup extends Model
{
    use SearchableModelTrait, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'admin_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'admin_team_id',
        'name',
        'slug',
        'abbreviation',
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
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'admin_team_id', 'name', 'abbreviation', 'public', 'readonly', 'root',
        'disabled', 'demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

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

        $query = new self()->getSearchQuery($filters)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['admin_team_id']), function ($query) use ($filters) {
                $query->where('admin_team_id', '=', intval($filters['admin_team_id']));
            })
            ->when(!empty($filters['abbreviation']), function ($query) use ($filters) {
                $query->where('abbreviation', '=', $filters['abbreviation']);
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system owner of the admin group.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the members for the admin group.
     *
     * @return BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class)
            ->orderBy('name');
    }

    /**
     * Get the system admin team that owns the admin group.
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(AdminTeam::class, 'admin_team_id');
    }
}
