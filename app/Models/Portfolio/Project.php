<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\ProjectFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'featured',
        'summary',
        'project_year',
        'language',
        'language_version',
        'repository_url',
        'repository_name',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'featured', 'summary', 'project_year', 'language',
        'language_version', 'repository_url', 'repository_name', 'notes', 'description', 'disclaimer',  'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'is_demo|desc'       => 'demo',
        'is_disabled|desc'   => 'disabled',
        'featured|desc'      => 'featured',
        'id|asc'             => 'id',
        'language|asc'       => 'language',
        'name|asc'           => 'name',
        'owner_id|asc'       => 'owner id',
        'owner_name|asc'     => 'owner name',
        'owner_username|asc' => 'owner username',
        'is_public|desc'     => 'public',
        'is_readonly|desc'   => 'read-only',
        'repository_url|asc' => 'repository',
        'is_root|desc'       => 'root',
        'sequence|asc'       => 'sequence',
        'project_year|desc'  => 'year',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'is_disabled', 'language', 'name', 'is_public', 'repository', 'project_year', ],
        'guest' => [ 'language', 'name', 'repository', 'project_year', ],
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
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['language']), function ($query) use ($filters) {
                $query->where($this->table . '.language', 'like', '%' . $filters['language'] . '%');
            })
            ->when(!empty($filters['language_version']), function ($query) use ($filters) {
                $query->where($this->table . '.language_version', 'like', '%' . $filters['language_version'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['repository']), function ($query) use ($filters) {
                $repository = $filters['repository'];
                $query->where(function ($query) use ($repository) {
                    $query->where($this->table . '.repository_url', 'like', '%' . $repository . '%')
                        ->orWhere($this->table . '.repository_name', 'like', '%' . $repository . '%');
                });
            })
            ->when(!empty($filters['repository_name']), function ($query) use ($filters) {
                $query->where($this->table . '.repository_name', 'like', '%' . $filters['repository_name'] . '%');
            })
            ->when(!empty($filters['repository_url']), function ($query) use ($filters) {
                $query->where($this->table . '.repository_url', 'like', '%' . $filters['repository_url'] . '%');
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['project_year']), function ($query) use ($filters) {
                $query->where($this->table . '.project_year', '=', intval($filters['project_year']));
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the portfolio project.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }
}
