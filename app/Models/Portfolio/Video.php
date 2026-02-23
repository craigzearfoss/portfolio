<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\VideoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'parent_id', 'id', 'owner_id', 'name', 'featured', 'summary', 'full_episode',
        'clip', 'public_access', 'source_recording', 'video_date', 'video_year', 'company', 'credit', 'show',
        'location', 'video_url', 'review_link1', 'review_link1_name', 'review_link2', 'review_link2_name',
        'review_link3', 'review_link3_name', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

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
        $query = new self()->getSearchQuery($filters, $owner)
            ->when(isset($filters['parent_id']), function ($query) use ($filters) {
                $query->where('parent_id', '=', intval(['parent_id']));
            })
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where('summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(isset($filters['full_episode']), function ($query) use ($filters) {
                $query->where('full_episode', '=', boolval(['full_episode']));
            })
            ->when(isset($filters['clip']), function ($query) use ($filters) {
                $query->where('clip', '=', boolval(['clip']));
            })
            ->when(isset($filters['public_access']), function ($query) use ($filters) {
                $query->where('public_access', '=', boolval(['public_access']));
            })
            ->when(isset($filters['source_recording']), function ($query) use ($filters) {
                $query->where('source_recording', '=', boolval(['source_recording']));
            })
            ->when(isset($filters['video_date']), function ($query) use ($filters) {
                $query->where('video_date', '=', $filters['video_date']);
            })
            ->when(isset($filters['video_year']), function ($query) use ($filters) {
                $query->where('video_year', '=', intval($filters['video_year']));
            })
            ->when(!empty($filters['company']), function ($query) use ($filters) {
                $query->where('company', 'like', '%' . $filters['company'] . '%');
            })
            ->when(!empty($filters['credit']), function ($query) use ($filters) {
                $query->where('credit', 'like', '%' . $filters['credit'] . '%');
            })
            ->when(!empty($filters['show']), function ($query) use ($filters) {
                $query->where('show', 'like', '%' . $filters['show'] . '%');
            })
            ->when(!empty($filters['location']), function ($query) use ($filters) {
                $query->where('location', 'like', '%' . $filters['location'] . '%');
            })
            ->when(!empty($filters['video_url']), function ($query) use ($filters) {
                $query->where('video_url', 'like', '%' . $filters['video_url'] . '%');
            })
            ->when(!empty($filters['review']), function ($query) use ($filters) {
                $review = $filters['review'];
                $query->orWhere(function ($query) use ($review) {
                    $query->where('review_link1', 'LIKE', '%' . $review . '%')
                        ->orWhere('review_link1_name', 'LIKE', '%' . $review . '%')
                        ->where('review_link2', 'LIKE', '%' . $review . '%')
                        ->orWhere('review_link2_name', 'LIKE', '%' . $review . '%')
                        ->where('review_link3', 'LIKE', '%' . $review . '%')
                        ->orWhere('review_link3_name', 'LIKE', '%' . $review . '%');
                });
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where('disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            });

        return $this->appendStandardFilters($query, $filters);
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
