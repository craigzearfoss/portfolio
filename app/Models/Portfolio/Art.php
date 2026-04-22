<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\ArtFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Art extends Model
{
    /** @use HasFactory<ArtFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'art';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'artist',
        'slug',
        'featured',
        'summary',
        'year',
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'owner_name', 'owner_username', 'name', 'artist', 'slug',
        'featured', 'summary', 'year', 'notes', 'link', 'link_name', 'description', 'disclaimer', 'image',
        'image_credit', 'image_source', 'thumbnail', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'demo',
        'sequence', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'artist|asc'         => 'artist',
        'created_at|desc'    => 'date created',
        'updated_at|desc'    => 'date updated',
        'is_demo|desc'       => 'demo',
        'is_disabled|desc'   => 'disabled',
        'featured|desc'      => 'featured',
        'id|asc'             => 'id',
        'name|asc'           => 'name',
        'is_public|desc'     => 'public',
        'owner_id|asc'       => 'owner id',
        'owner_name|asc'     => 'owner name',
        'owner_username|asc' => 'owner username',
        'is_readonly|desc'   => 'read-only',
        'is_root|desc'       => 'root',
        'sequence|asc'       => 'sequence',
        'year|asc'           => 'year',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'artist', 'is_disabled', 'name', 'is_public', 'year', ],
        'guest' => [ 'artist', 'name', 'year' ],
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
            ->when(!empty($filters['artist']), function ($query) use ($filters) {
                $query->where($this->table . '.artist', 'like', '%' . $filters['artist'] . '%');
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
            ->when(!empty($filters['image']), function ($query) use ($filters) {
                $query->where($this->table . '.image', 'like', '%' . $filters['image'] . '%');
            })
            ->when(!empty($filters['image_credit']), function ($query) use ($filters) {
                $query->where($this->table . '.image_credit', 'like', '%' . $filters['image_credit'] . '%');
            })
            ->when(!empty($filters['image_source']), function ($query) use ($filters) {
                $query->where($this->table . '.image_source', 'like', '%' . $filters['image_source'] . '%');
            })
            ->when(!empty($filters['link']), function ($query) use ($filters) {
                $query->where($this->table . '.link', 'like', '%' . $filters['link'] . '%');
            })
            ->when(!empty($filters['link_name']), function ($query) use ($filters) {
                $query->where($this->table . '.link_name', 'like', '%' . $filters['link_name'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['slug']), function ($query) use ($filters) {
                $query->where($this->table . '.slug', 'like', '%' . $filters['slug'] . '%');
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['thumbnail']), function ($query) use ($filters) {
                $query->where($this->table . '.thumbnail', 'like', '%' . $filters['thumbnail'] . '%');
            })
            ->when(!empty($filters['year']), function ($query) use ($filters) {
                $query->where($this->table . '.year', '=', intval($filters['year']));
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the art.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }
}
