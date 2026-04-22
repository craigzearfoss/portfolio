<?php

namespace App\Models\Dictionary;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class OperatingSystem extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
    protected $table = 'operating_systems';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'name',
        'slug',
        'abbreviation',
        'definition',
        'open_source',
        'proprietary',
        'compiled',
        'owner',
        'wikipedia',
        'link',
        'link_name',
        'description',
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
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'name', 'full_name', 'abbreviation', 'open_source', 'proprietary', 'compiled',
        'owner', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        //
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
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['compiled']), function ($query) use ($filters) {
                $query->where($this->table . '.compiled', '=', true);
            })
            ->when(!empty($filters['definition']), function ($query) use ($filters) {
                $query->where($this->table . '.definition', 'like', '%' . $filters['definition'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $name = $filters['name'];
                $query->orWhere(function ($query) use ($name) {
                    $query->where($this->table . '.full_name', 'LIKE', '%' . $name . '%')
                        ->orWhere($this->table . '.name', 'LIKE', '%' . $name . '%')
                        ->orWhere($this->table . '.abbreviation', 'LIKE', '%' . $name . '%');
                });
            })
            ->when(!empty($filters['open_source']), function ($query) use ($filters) {
                $query->where($this->table . '.open_source', '=', true);
            })
            ->when(!empty($filters['owner']), function ($query) use ($filters) {
                $query->where($this->table . '.owner', 'like', '%' . $filters['owner'] . '%');
            })
            ->when(!empty($filters['proprietary']), function ($query) use ($filters) {
                $query->where($this->table . '.proprietary', '=', true);
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Return the stacks for the operating system.
     *
     * @return BelongsToMany
     */
    public function stacks(): BelongsToMany
    {
        return $this->belongsToMany(Stack::class);
    }
}
