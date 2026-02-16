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
use Illuminate\Http\Request;

/**
 * @mixin Eloquent
 * @mixin Builder
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
        'owner_id',
        'title',
        'slug',
        'parent_id',
        'featured',
        'summary',
        'publication_name',
        'publisher',
        'date',
        'year',
        'credit',
        'freelance',
        'fiction',
        'nonfiction',
        'technical',
        'research',
        'poetry',
        'online',
        'novel',
        'book',
        'textbook',
        'story',
        'article',
        'paper',
        'pamphlet',
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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'title', 'parent_id', 'featured', 'publication_name', 'publisher',
        'date', 'year', 'credit', 'freelance', 'fiction', 'nonfiction', 'technical', 'research', 'poetry', 'online',
        'novel', 'book', 'textbook', 'story', 'article', 'paper', 'pamphlet', 'public', 'readonly', 'root', 'disabled',
        'demo'];

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
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['parent_id']), function ($query) use ($filters) {
                $query->where('parent_id', '=', intval($filters['parent_id']));
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(!empty($filters['publication_name']), function ($query) use ($filters) {
                $query->where('publication_name', 'like', '%' . $filters['publication_name'] . '%');
            })
            ->when(!empty($filters['publisher']), function ($query) use ($filters) {
                $query->where('publisher', 'like', '%' . $filters['publisher'] . '%');
            })
            ->when(!empty($filters['date']), function ($query) use ($filters) {
                $query->where('date', '=', $filters['date']);
            })
            ->when(!empty($filters['year']), function ($query) use ($filters) {
                $query->where('year', '=', intval($filters['year']));
            })
            ->when(!empty($filters['credit']), function ($query) use ($filters) {
                $query->where('credit', 'like', '%' . $filters['credit'] . '%');
            })
            ->when(isset($filters['fiction']), function ($query) use ($filters) {
                $query->where('fiction', '=', boolval($filters['fiction']));
            })
            ->when(isset($filters['nonfiction']), function ($query) use ($filters) {
                $query->where('nonfiction', '=', boolval($filters['nonfiction']));
            })
            ->when(isset($filters['technical']), function ($query) use ($filters) {
                $query->where('technical', '=', boolval($filters['technical']));
            })
            ->when(isset($filters['research']), function ($query) use ($filters) {
                $query->where('research', '=', boolval($filters['research']));
            })
            ->when(isset($filters['freelance']), function ($query) use ($filters) {
                $query->where('freelance', '=', boolval($filters['freelance']));
            })
            ->when(isset($filters['online']), function ($query) use ($filters) {
                $query->where('online', '=', boolval($filters['online']));
            })
            ->when(isset($filters['novel']), function ($query) use ($filters) {
                $query->where('novel', '=', boolval($filters['novel']));
            })
            ->when(isset($filters['book']), function ($query) use ($filters) {
                $query->where('book', '=', boolval($filters['book']));
            })
            ->when(isset($filters['textbook']), function ($query) use ($filters) {
                $query->where('textbook', '=', boolval($filters['textbook']));
            })
            ->when(isset($filters['story']), function ($query) use ($filters) {
                $query->where('story', '=', boolval($filters['story']));
            })
            ->when(isset($filters['article']), function ($query) use ($filters) {
                $query->where('article', '=', boolval($filters['article']));
            })
            ->when(isset($filters['paper']), function ($query) use ($filters) {
                $query->where('paper', '=', boolval($filters['paper']));
            })
            ->when(isset($filters['pamphlet']), function ($query) use ($filters) {
                $query->where('pamphlet', '=', boolval($filters['pamphlet']));
            })
            ->when(isset($filters['poetry']), function ($query) use ($filters) {
                $query->where('poetry', '=', boolval($filters['poetry']));
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
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
