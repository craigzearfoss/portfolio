<?php

namespace App\Models\Dictionary;

use App\Enums\EnvTypes;
use App\Models\Portfolio\JobSkill;
use App\Models\Portfolio\Skill;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Category extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
    protected $table = 'categories';

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
     * Returns an array of options for a dictionary section select list.
     *
     * @param array $filters
     * @param string $valueColumn - id, name, slug, table, or route
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther
     * @param array $orderBy
     * @param EnvTypes|null $envType
     * @return array|string[]
     */
    public function listOptions(array         $filters = [],
                                string        $valueColumn = 'id',
                                string        $labelColumn = 'name',
                                bool          $includeBlank = false,
                                bool          $includeOther = false,
                                array         $orderBy = [],
                                EnvTypes|null $envType = EnvTypes::GUEST): array
    {
        if (!in_array($valueColumn, ['id', 'name', 'full_name', 'slug', 'route'])) {
            return [];
        }

        $other = null;

        // set the order by
        $sortColumn = $orderBy[0] ?? self::SEARCH_ORDER_BY[0];
        if (!in_array($sortColumn, self::PREDEFINED_SEARCH_COLUMNS)) {
            $sortColumn = 'name';
        }
        $sortDir = $orderBy[1] ?? self::SEARCH_ORDER_BY[1];

        if ($includeBlank) {
            $key = ($valueColumn == 'route') ? route((!empty($envType) ? $envType->value . '.' : '') . 'dictionary.category.index') : '';
            $options = [ $key => '' ];
        } else {
            $options = [];
        }

        if ($includeBlank) {
            $key = $valueColumn == 'route'
                ? route((!empty($envType) ? $envType->value . '.' : '') . 'dictionary.category.index')
                : '';
            $options = [
                $key => ''
            ];
        }

        // create the query
        $query = new Category()->select('id', 'name', 'full_name', 'slug')
            ->orderBy($sortColumn, $sortDir);

        // apply filters to the query
        foreach ($filters as $column => $value) {
            $query = $query->where($column, '=', $value);
        }

        foreach ($query->get() as $col => $dictionaryCategory) {

            switch ($valueColumn) {
                case 'id':
                case 'name':
                case 'full_name':
                case 'slug':
                    $key = $dictionaryCategory->{$valueColumn};
                    break;
                case 'route':
                    $key = route((!empty($envType) ? $envType->value . '.' : '')
                        . 'dictionary.' . $dictionaryCategory->slug . '.index');
                    break;
            }

            if (!empty($key)) {
                if (strtoupper($dictionaryCategory->{$labelColumn}) != 'OTHER') {
                    $options[$key] = ucwords($dictionaryCategory->{$labelColumn});
                }
            }
        }

        return $options;
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
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $name = $filters['name'];
                $query->orWhere(function ($query) use ($name) {
                    $query->where($this->table . '.full_name', 'LIKE', '%' . $name . '%')
                        ->orWhere($this->table . '.name', 'LIKE', '%' . $name . '%')
                        ->orWhere($this->table . '.abbreviation', 'LIKE', '%' . $name . '%');
                });
            })
            ->when(!empty($filters['compiled']), function ($query) use ($filters) {
                $query->where($this->table . '.compiled', '=', true);
            })
            ->when(!empty($filters['definition']), function ($query) use ($filters) {
                $query->where($this->table . '.definition', 'like', '%' . $filters['definition'] . '%');
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
     * Get the career job skills for the dictionary category.
     *
     * @return HasMany
     */
    public function jobSkills(): HasMany
    {
        return $this->hasMany(JobSkill::class, 'dictionary_category_id')
            ->orderBy('id');
    }

    /**
     * Get the career skills for the dictionary category.
     *
     * @return HasMany
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'dictionary_category_id')
            ->orderBy('id');
    }
}
