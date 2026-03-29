<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\PublicationFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Publication extends Model
{
    /** @use HasFactory<PublicationFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'publications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'owner_id',
        'title',
        'slug',
        'featured',
        'summary',
        'publication_name',
        'publisher',
        'publication_date',
        'publication_year',
        'credit',
        'freelance',
        'fiction',
        'nonfiction',
        'technical',
        'research',
        'freelance',
        'online',
        'novel',
        'book',
        'textbook',
        'story',
        'article',
        'paper',
        'pamphlet',
        'poetry',
        'publication_url',
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
    const array SEARCH_COLUMNS = [ 'parent_id', 'id', 'owner_id', 'title', 'featured', 'publication_name', 'publisher',
        'publication_date', 'publication_year', 'credit', 'fiction', 'nonfiction', 'technical', 'research', 'freelance',
        'online', 'novel', 'book', 'textbook', 'story', 'article', 'paper', 'pamphlet', 'poetry', 'notes',
        'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_emo' ];

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

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['article']), function ($query) use ($filters) {
                $query->where('article', '=', true);
            })
            ->when(!empty($filters['book']), function ($query) use ($filters) {
                $query->where('book', '=', true);
            })
            ->when(!empty($filters['credit']), function ($query) use ($filters) {
                $query->where('credit', 'like', '%' . $filters['credit'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where('disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', true);
            })
            ->when(!empty($filters['fiction']), function ($query) use ($filters) {
                $query->where('fiction', '=', true);
            })
            ->when(!empty($filters['freelance']), function ($query) use ($filters) {
                $query->where('freelance', '=', true);
            })
            ->when(!empty($filters['nonfiction']), function ($query) use ($filters) {
                $query->where('nonfiction', '=', true);
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['novel']), function ($query) use ($filters) {
                $query->where('novel', '=', true);
            })
            ->when(!empty($filters['online']), function ($query) use ($filters) {
                $query->where('online', '=', true);
            })
            ->when(!empty($filters['pamphlet']), function ($query) use ($filters) {
                $query->where('pamphlet', '=', true);
            })
            ->when(!empty($filters['paper']), function ($query) use ($filters) {
                $query->where('paper', '=', true);
            })
            ->when(isset($filters['parent_id']), function ($query) use ($filters) {
                $query->where('parent_id', '=', intval($filters['parent_id']));
            })
            ->when(!empty($filters['poetry']), function ($query) use ($filters) {
                $query->where('poetry', '=', true);
            })
            ->when(!empty($filters['publication_date']), function ($query) use ($filters) {
                $query->where('publication_date', '=', $filters['publication_date']);
            })
            ->when(!empty($filters['publication_name']), function ($query) use ($filters) {
                $query->where('publication_name', 'like', '%' . $filters['publication_name'] . '%');
            })
            ->when(!empty($filters['publication_url']), function ($query) use ($filters) {
                $query->where('publication_url', 'like', '%' . $filters['publication_url'] . '%');
            })
            ->when(!empty($filters['publication_year']), function ($query) use ($filters) {
                $query->where('publication_year', '=', intval($filters['publication_year']));
            })
            ->when(!empty($filters['publisher']), function ($query) use ($filters) {
                $query->where('publisher', 'like', '%' . $filters['publisher'] . '%');
            })
            ->when(!empty($filters['research']), function ($query) use ($filters) {
                $query->where('research', '=', true);
            })
            ->when(!empty($filters['review']), function ($query) use ($filters) {
                $review = $filters['review'];
                $query->orWhere(function ($query) use ($review) {
                    $query->where('review_link1', 'like', '%' . $review . '%')
                        ->orWhere('review_link1_name', 'like', '%' . $review . '%')
                        ->where('review_link2', 'kile', '%' . $review . '%')
                        ->orWhere('review_link2_name', 'like', '%' . $review . '%')
                        ->where('review_link3', 'like', '%' . $review . '%')
                        ->orWhere('review_link3_name', 'like', '%' . $review . '%');
                });
            })
            ->when(!empty($filters['story']), function ($query) use ($filters) {
                $query->where('story', '=', true);
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where('summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['technical']), function ($query) use ($filters) {
                $query->where('technical', '=', true);
            })
            ->when(!empty($filters['textbook']), function ($query) use ($filters) {
                $query->where('textbook', '=', true);
            })
            ->when(!empty($filters['search_title']), function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search_title'] . '%');
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Get the system owner of the publication.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the portfolio publication.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Publication::class, 'parent_id');
    }

    /**
     * Get the children of the portfolio publication.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Publication::class, 'parent_id');
    }
}
