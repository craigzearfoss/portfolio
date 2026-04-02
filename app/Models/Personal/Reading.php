<?php

namespace App\Models\Personal;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Reading extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'personal_db';

    /**
     * @var string
     */
    protected $table = 'readings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'title',
        'author',
        'slug',
        'featured',
        'summary',
        'publication_year',
        'fiction',
        'nonfiction',
        'paper',
        'audio',
        'wishlist',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'title', 'author', 'featured', 'summary', 'publication_year',
        'fiction', 'nonfiction', 'paper', 'audio', 'wishlist', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'title', 'asc' ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

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
        $filters = $this->removeEmptyFilters($filters);

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['audio']), function ($query) use ($filters) {
                $query->where($this->table . '.audio', '=', true);
            })
            ->when(!empty($filters['author']), function ($query) use ($filters) {
                $query->where($this->table . '.author', 'like', '%' . $filters['author'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', 'like', '%' . $filters['featured'] . '%');
            })
            ->when(!empty($filters['fiction']), function ($query) use ($filters) {
                $query->where($this->table . '.fiction', '=', true);
            })
            ->when(!empty($filters['nonfiction']), function ($query) use ($filters) {
                $query->where($this->table . '.nonfiction', '=', true);
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['paper']), function ($query) use ($filters) {
                $query->where($this->table . '.paper', '=', true);
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(!empty($filters['wishlist']), function ($query) use ($filters) {
                $query->where($this->table . '.wishlist', '=', true);
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Get the system owner of the reading.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }
}
