<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\PublicationFactory;
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'parent_id', 'id', 'owner_id', 'title', 'featured', 'publication_name', 'publisher',
        'publication_date', 'publication_year', 'credit', 'fiction', 'nonfiction', 'technical', 'research', 'freelance',
        'online', 'novel', 'book', 'textbook', 'story', 'article', 'paper', 'pamphlet', 'poetry', 'notes',
        'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at',
        'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'title', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc'      => 'datetime created',
        'updated_at|desc'      => 'datetime updated',
        'is_demo|desc'         => 'demo',
        'is_disabled|desc'     => 'disabled',
        'featured|desc'        => 'featured',
        'id|asc'               => 'id',
        'owner_id|asc'         => 'owner id',
        'owner_name|asc'       => 'owner name',
        'owner_username|asc'   => 'owner username',
        'is_public|desc'       => 'public',
        'publication_name|asc' => 'publication',
        'publisher|asc'        => 'publisher',
        'is_readonly|desc'     => 'read-only',
        'is_root|desc'         => 'root',
        'sequence|asc'         => 'sequence',
        'title|asc'            => 'title',
        'publication_year|asc' => 'year',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'is_disabled', 'publication_name', 'publisher', 'title', 'is_public', 'publication_year', ],
        'guest' => [ 'publication_name', 'publisher', 'title', 'publication_year', ],
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

        $query = $this->getSearchQuery($filters, $owner)
            ->when(!empty($filters['article']), function ($query) use ($filters) {
                $query->where($this->table . '.article', '=', true);
            })
            ->when(!empty($filters['book']), function ($query) use ($filters) {
                $query->where($this->table . '.book', '=', true);
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
            ->when(!empty($filters['fiction']), function ($query) use ($filters) {
                $query->where($this->table . '.fiction', '=', true);
            })
            ->when(!empty($filters['freelance']), function ($query) use ($filters) {
                $query->where($this->table . '.freelance', '=', true);
            })
            ->when(!empty($filters['nonfiction']), function ($query) use ($filters) {
                $query->where($this->table . '.nonfiction', '=', true);
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['novel']), function ($query) use ($filters) {
                $query->where($this->table . '.novel', '=', true);
            })
            ->when(!empty($filters['online']), function ($query) use ($filters) {
                $query->where($this->table . '.online', '=', true);
            })
            ->when(!empty($filters['pamphlet']), function ($query) use ($filters) {
                $query->where($this->table . '.pamphlet', '=', true);
            })
            ->when(!empty($filters['paper']), function ($query) use ($filters) {
                $query->where($this->table . '.paper', '=', true);
            })
            ->when(!empty($filters['parent_id']), function ($query) use ($filters) {
                $query->where($this->table . '.parent_id', '=', intval($filters['parent_id']));
            })
            ->when(!empty($filters['poetry']), function ($query) use ($filters) {
                $query->where($this->table . '.poetry', '=', true);
            })
            ->when(!empty($filters['publication_date']), function ($query) use ($filters) {
                $query->where($this->table . '.publication_date', '=', $filters['publication_date']);
            })
            ->when(!empty($filters['publication_name']), function ($query) use ($filters) {
                $query->where($this->table . '.publication_name', 'like', '%' . $filters['publication_name'] . '%');
            })
            ->when(!empty($filters['publication_url']), function ($query) use ($filters) {
                $query->where($this->table . '.publication_url', 'like', '%' . $filters['publication_url'] . '%');
            })
            ->when(!empty($filters['publication_year']), function ($query) use ($filters) {
                $query->where($this->table . '.publication_year', '=', intval($filters['publication_year']));
            })
            ->when(!empty($filters['publisher']), function ($query) use ($filters) {
                $query->where($this->table . '.publisher', 'like', '%' . $filters['publisher'] . '%');
            })
            ->when(!empty($filters['research']), function ($query) use ($filters) {
                $query->where($this->table . '.research', '=', true);
            })
            ->when(!empty($filters['review']), function ($query) use ($filters) {
                $review = $filters['review'];
                $query->orWhere(function ($query) use ($review) {
                    $query->where($this->table . '.review_link1', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link1_name', 'like', '%' . $review . '%')
                        ->where($this->table . '.review_link2', 'kile', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link2_name', 'like', '%' . $review . '%')
                        ->where($this->table . '.review_link3', 'like', '%' . $review . '%')
                        ->orWhere($this->table . '.review_link3_name', 'like', '%' . $review . '%');
                });
            })
            ->when(!empty($filters['story']), function ($query) use ($filters) {
                $query->where($this->table . '.story', '=', true);
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['technical']), function ($query) use ($filters) {
                $query->where($this->table . '.technical', '=', true);
            })
            ->when(!empty($filters['textbook']), function ($query) use ($filters) {
                $query->where($this->table . '.textbook', '=', true);
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(!empty($filters['search_title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['search_title'] . '%');
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
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
