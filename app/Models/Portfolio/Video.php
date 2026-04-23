<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\VideoFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'owner_id',
        'name',
        'slug',
        'featured',
        'summary',
        'full_episode',
        'clip',
        'public_access',
        'source_recording',
        'video_date',
        'video_year',
        'company',
        'credit',
        'show',
        'location',
        'embed',
        'video_url',
        'review_link1',
        'review_link1_name',
        'review_link2',
        'review_link2_name',
        'review_link3',
        'review_link3_name',
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'parent_id', 'id', 'owner_id', 'name', 'featured', 'summary', 'full_episode',
        'clip', 'public_access', 'source_recording', 'video_date', 'video_year', 'company', 'credit', 'show',
        'location', 'video_url', 'review_link1', 'review_link1_name', 'review_link2', 'review_link2_name',
        'review_link3', 'review_link3_name', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'company|asc'        => 'company',
        'credit|asc'         => 'credit',
        'video_date|desc'    => 'date',
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'is_demo|desc'       => 'demo',
        'is_disabled|desc'   => 'disabled',
        'featured|desc'      => 'featured',
        'id|asc'             => 'id',
        'location|asc'       => 'location',
        'name|asc'           => 'name',
        'owner_id|asc'       => 'owner id',
        'owner_name|asc'     => 'owner name',
        'owner_username|asc' => 'owner username',
        'is_public|desc'     => 'public',
        'is_readonly|desc'   => 'read-only',
        'is_root|desc'       => 'root',
        'sequence|asc'       => 'sequence',
        'show|asc'           => 'show',
        'video_year|asc'     => 'year',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'company', 'is_disabled', 'name', 'show', 'is_public', 'video_year', ],
        'guest' => [ 'company', 'name', 'show', 'video_year', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

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
     * @param string|null $sort - column for sort order, append "|asc" or "|desc" to specify direction
     * @param Admin|Owner|null $owner
     * @param User|null $user
     * @return Builder
     * @throws Exception
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['clip']), function ($query) use ($filters) {
                $query->where($this->table . '.clip', '=', boolval($filters['clip']));
            })
            ->when(!empty($filters['company']), function ($query) use ($filters) {
                $query->where($this->table . '.company', 'like', '%' . $filters['company'] . '%');
            })
            ->when(!empty($filters['credit']), function ($query) use ($filters) {
                $query->where($this->table . '.credit', 'like', '%' . $filters['credit'] . '%');
            })
            ->when(!empty($filters['date']), function ($query) use ($filters) {
                $query->where($this->table . '.date', '=', $filters['date']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', boolval($filters['featured']));
            })
            ->when(!empty($filters['full_episode']), function ($query) use ($filters) {
                $query->where($this->table . '.full_episode', '=', boolval($filters['full_episode']));
            })
            ->when(!empty($filters['location']), function ($query) use ($filters) {
                $query->where($this->table . '.location', 'like', '%' . $filters['location'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['parent_id']), function ($query) use ($filters) {
                $query->where($this->table . '.parent_id', '=', intval($filters['parent_id']));
            })
            ->when(!empty($filters['public_access']), function ($query) use ($filters) {
                $query->where($this->table . '.public_access', '=', boolval($filters['public_access']));
            })
            ->when(!empty($filters['review']), function ($query) use ($filters) {
                $review = $filters['review'];
                $query->orWhere(function ($query) use ($review) {
                    $query->where($this->table . '.review_link1', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link1_name', 'like', '%' . $review . '%')
                        ->where($this->table . '.review_link2', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link2_name', 'like', '%' . $review . '%')
                        ->where($this->table . '.review_link3', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link3_name', 'like', '%' . $review . '%');
                });
            })
            ->when(!empty($filters['show']), function ($query) use ($filters) {
                $query->where($this->table . '.show', 'like', '%' . $filters['show'] . '%');
            })
            ->when(!empty($filters['source_recording']), function ($query) use ($filters) {
                $query->where($this->table . '.source_recording', '=', boolval(['source_recording']));
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['video_url']), function ($query) use ($filters) {
                $query->where($this->table . '.video_url', 'like', '%' . $filters['video_url'] . '%');
            })
            ->when(!empty($filters['video_year']), function ($query) use ($filters) {
                $query->where($this->table . '.video_year', '=', intval($filters['video_year']));
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the video.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the portfolio video.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Video::class, 'parent_id');
    }

    /**
     * Get the children of the portfolio video.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Video::class, 'parent_id');
    }
}
