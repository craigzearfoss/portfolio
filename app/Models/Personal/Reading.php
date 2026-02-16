<?php

namespace App\Models\Personal;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'title', 'author', 'featured', 'publication_year', 'fiction',
        'nonfiction', 'paper', 'audio', 'wishlist', 'public', 'readonly', 'root', 'disabled', 'demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['title', 'asc'];

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
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        return new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(!empty($filters['author']), function ($query) use ($filters) {
                $query->where('author', 'like', '%' . $filters['author'] . '%');
            })
            ->when(isset($filters['fiction']), function ($query) use ($filters) {
                $query->where('fiction', '=', boolval($filters['fiction']));
            })
            ->when(isset($filters['nonfiction']), function ($query) use ($filters) {
                $query->where('nonfiction', '=', boolval($filters['nonfiction']));
            })
            ->when(isset($filters['paper']), function ($query) use ($filters) {
                $query->where('paper', '=', boolval($filters['paper']));
            })
            ->when(isset($filters['audio']), function ($query) use ($filters) {
                $query->where('audio', '=', boolval($filters['audio']));
            })
            ->when(isset($filters['wishlist']), function ($query) use ($filters) {
                $query->where('wishlist', '=', boolval($filters['wishlist']));
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
    }

    /**
     * Get the system owner of the reading.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }
}
