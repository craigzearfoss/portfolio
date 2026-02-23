<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\AudioFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Audio extends Model
{
    /** @use HasFactory<AudioFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'audios';

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
        'podcast',
        'source_recording',
        'date',
        'year',
        'company',
        'credit',
        'show',
        'location',
        'embed',
        'audio_url',
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
    const array SEARCH_COLUMNS = [ 'id', 'parent_id', 'owner_id', 'name', 'featured', 'summary', 'full_episode',
        'clip', 'podcast', 'source_recording', 'date', 'year', 'company', 'credit', 'show', 'location', 'audio_url',
        'review_link1', 'review_link1_name', 'review_link2', 'review_link2_name', 'review_link3', 'review_link3_name',
        'notes','description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

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
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval($filters['featured']));
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where('summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(isset($filters['full_episode']), function ($query) use ($filters) {
                $query->where('full_episode', '=', boolval($filters['full_episode']));
            })
            ->when(isset($filters['clip']), function ($query) use ($filters) {
                $query->where('clip', '=', boolval($filters['clip']));
            })
            ->when(isset($filters['podcast']), function ($query) use ($filters) {
                $query->where('podcast', '=', boolval($filters['podcast']));
            })
            ->when(isset($filters['source_recording']), function ($query) use ($filters) {
                $query->where('source_recording', '=', boolval(['source_recording']));
            })
            ->when(!empty($filters['date']), function ($query) use ($filters) {
                $query->where('date', '=', $filters['date']);
            })
            ->when(!empty($filters['year']), function ($query) use ($filters) {
                $query->where('year', '=', $filters['year']);
            })
            ->when(!empty($filters['company']), function ($query) use ($filters) {
                $query->where('company', 'like', '%' . $filters['company'] . '%');
            })
            ->when(!empty($filters['credit']), function ($query) use ($filters) {
                $query->where('credit', 'like', '%' . $filters['credit'] . '%');
            })
            ->when(isset($filters['show']), function ($query) use ($filters) {
                $query->where('show', '=', boolval($filters['show']));
            })
            ->when(!empty($filters['location']), function ($query) use ($filters) {
                $query->where('location', 'like', '%' . $filters['location'] . '%');
            })
            ->when(!empty($filters['url']), function ($query) use ($filters) {
                $url = $filters['url'];
                $query->orWhere(function ($query) use ($url) {
                    $query->where('audio_url', 'LIKE', '%' . $url . '%')
                        ->orWhere('review_link1', 'LIKE', '%' . $url . '%')
                        ->orWhere('review_link1_name', 'LIKE', '%' . $url . '%')
                        ->orWhere('review_link2', 'LIKE', '%' . $url . '%')
                        ->orWhere('review_link2_name', 'LIKE', '%' . $url . '%')
                        ->orWhere('review_link3', 'LIKE', '%' . $url . '%')
                        ->orWhere('review_link3_name', 'LIKE', '%' . $url . '%');
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
     * Get the system owner of the audio.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the portfolio audio.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Audio::class, 'parent_id');
    }

    /**
     * Get the children of the portfolio audio.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Audio::class, 'parent_id');
    }
}
