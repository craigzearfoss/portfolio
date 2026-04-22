<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\MusicFactory;
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
class Music extends Model
{
    /** @use HasFactory<MusicFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'music';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'parent_id',
        'owner_id',
        'name',
        'artist',
        'slug',
        'featured',
        'summary',
        'collection',
        'track',
        'label',
        'catalog_number',
        'music_year',
        'release_date',
        'embed',
        'audio_url',
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
    const array SEARCH_COLUMNS = [ 'id', 'parent_id', 'owner_id', 'name', 'artist', 'featured', 'summary', 'collection',
        'track', 'label', 'catalog_number', 'music_year', 'release_date', 'audio_url', 'notes', 'description',
        'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
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
        'catalog_number|asc' => 'catalog number',
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'is_demo|desc'       => 'demo',
        'is_disabled|desc'   => 'disabled',
        'featured|desc'      => 'featured',
        'id|asc'             => 'id',
        'label|asc'          => 'label',
        'name|asc'           => 'name',
        'owner_id|asc'       => 'owner id',
        'owner_name|asc'     => 'owner name',
        'owner_username|asc' => 'owner username',
        'is_public|desc'     => 'public',
        'is_readonly|desc'   => 'read-only',
        'is_root|desc'       => 'root',
        'sequence|asc'       => 'sequence',
        'music_year|asc'     => 'year',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'artist', 'catalog number', 'is_disabled', 'label', 'name', 'is_public', 'music_year', ],
        'guest' => [ 'artist', 'catalog_number','label', 'name', 'music_year', ],
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
            ->when(!empty($filters['audio_url']), function ($query) use ($filters) {
                $query->where($this->table . '.audio_url', '=', ['audio_url']);
            })
            ->when(!empty($filters['catalog_number']), function ($query) use ($filters) {
                $query->where($this->table . '.catalog_number', 'like', '%' . $filters['catalog_number'] . '%');
            })
            ->when(!empty($filters['collection']), function ($query) use ($filters) {
                $query->where($this->table . '.collection', '=', true);
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
            ->when(!empty($filters['search_label']), function ($query) use ($filters) {
                $query->where($this->table . '.label', 'like', '%' . $filters['search_label'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['parent_id']), function ($query) use ($filters) {
                $query->where($this->table . '.parent_id', '=', intval($filters['parent_id']));
            })
            ->when(!empty($filters['release_date']), function ($query) use ($filters) {
                $query->where($this->table . '.release_date', '=', ['release_date']);
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters[$this->table . '.track']), function ($query) use ($filters) {
                $query->where('track', '=', true);
            })
            ->when(!empty($filters['music_year']), function ($query) use ($filters) {
                $query->where('music_year', '=', intval($filters['music_year']));
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the music.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the portfolio music.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Music::class, 'parent_id');
    }

    /**
     * Get the children of the portfolio music.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Music::class, 'parent_id');
    }
}
