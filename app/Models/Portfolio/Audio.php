<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\AudioFactory;
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
        'audio_date',
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
        'clip', 'podcast', 'source_recording', 'audio_date', 'year', 'company', 'credit', 'show', 'location', 'audio_url',
        'review_link1', 'review_link1_name', 'review_link2', 'review_link2_name', 'review_link3', 'review_link3_name',
        'notes','description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     *
     */
    const array AUDIO_TYPES = [
        'podcast'          => 'podcast',
        'clip'             => 'clip'  ,
        'source_recording' => 'source recording',
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [];
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
     * @param string|null $sort
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
            ->when(!empty($filters['audio_date']), function ($query) use ($filters) {
                $query->where($this->table . '.audio_date', '=', $filters['audio_date']);
            })
            ->when(!empty($filters['audio_type']), function ($query) use ($filters) {
                if (in_array($filters['audio_type'], self::AUDIO_TYPES)) {
                    $query->where($this->table . '.'.$filters['audio_type'], '=', true);
                } else {
                    throw new Exception('Invalid audio_type "' . $filters['audio_type'] . '" specified.'
                        . ' Valid audio types are "' . implode('", "', self::AUDIO_TYPES) . '".');
                }
            })
            ->when(!empty($filters['audio_url']), function ($query) use ($filters) {
                $query->where($this->table . '.audio_url', 'like', '%' . $filters['publication_url'] . '%');
            })
            ->when(!empty($filters['clip']), function ($query) use ($filters) {
                $query->where($this->table . '.clip', '=', true);
            })
            ->when(!empty($filters['company']), function ($query) use ($filters) {
                $query->where($this->table . '.company', 'like', '%' . $filters['company'] . '%');
            })
            ->when(!empty($filters['credit']), function ($query) use ($filters) {
                $query->where($this->table . '.credit', 'like', '%' . $filters['credit'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['full_episode']), function ($query) use ($filters) {
                $query->where($this->table . '.full_episode', '=', true);
            })
            ->when(!empty($filters['location']), function ($query) use ($filters) {
                $query->where($this->table . '.location', 'like', '%' . $filters['location'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['parent_id']), function ($query) use ($filters) {
                $query->where($this->table . '.parent_id', '=', intval(['parent_id']));
            })
            ->when(!empty($filters['podcast']), function ($query) use ($filters) {
                $query->where($this->table . '.podcast', '=', true);
            })
            ->when(!empty($filters['review']), function ($query) use ($filters) {
                $review = $filters['review'];
                $query->orWhere(function ($query) use ($review) {
                    $query->where($this->table . '.review_link1', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link1_name', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link2', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link2_name', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link3', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link3_name', 'like', '%' . $review . '%');
                });
            })
            ->when(!empty($filters['show']), function ($query) use ($filters) {
                $query->where($this->table . '.show', '=', true);
            })
            ->when(!empty($filters['source_recording']), function ($query) use ($filters) {
                $query->where($this->table . '.source_recording', '=', true);
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['year']), function ($query) use ($filters) {
                $query->where($this->table . '.year', '=', $filters['year']);
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // join to owner
        $query = $this->addJoinToAdminTable($query);

        // add order by clause
        $query = $this->addOrderBy($query, $sort);
        if (explode('|', $sort ?? '') != 'owner_username') {
            $query->orderBy('owner_username');
        }

        return $query;
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
