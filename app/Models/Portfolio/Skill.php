<?php

namespace App\Models\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\SkillFactory;
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
class Skill extends Model
{
    /** @use HasFactory<SkillFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'version',
        'featured',
        'summary',
        'type_id', // 0=soft skill, 1=hard skill
        'level',
        'dictionary_category_id',
        'start_year',
        'end_year',
        'years',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'version', 'featured', 'summary', 'type_id', 'level',
        'dictionary_category_id', 'start_year', 'end_year', 'years', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'level', 'desc' ];

    /**
     *
     */
    const array TYPE = [
        0 => 'soft skill',
        1 => 'hard skill',
    ];

    /**
     *
     */
    const array LEVELS = [
        1 => '1 star',
        2 => '2 stars',
        3 => '3 stars',
        4 => '4 stars',
        5 => '5 stars',
        6 => '6 stars',
        7 => '7 stars',
        8 => '8 stars',
        9 => '9 stars',
        10 => '10 stars',
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [
            'dictionary_category_name'
        ];
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
     * Returns an array of options for a select list for skill type (soft skill, hard skill)
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public function salutationListOptions(bool $includeBlank = false): array
    {
        $options = $includeBlank ? [ '' => '' ] : [];

        foreach (self::TYPE as $type) {
            $options[$type] = $type;
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
            ->when(!empty($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where($this->table . '.dictionary_category_id', '=', intval($filters['dictionary_category_id']));
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['end_year']), function ($query) use ($filters) {
                $query->where($this->table . '.end_year', '=', intval($filters['end_year']));
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['level']), function ($query) use ($filters) {
                $query->where($this->table . '.level', '=', intval($filters['level']));
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['level']), function ($query) use ($filters) {
                $query->where($this->table . '.level)', '=', intval($filters['level']));
            })
            ->when(!empty($filters['max_level']), function ($query) use ($filters) {
                $query->where($this->table . '.level', '<=', intval($filters['max_level']));
            })
            ->when(!empty($filters['min_level']), function ($query) use ($filters) {
                $query->where($this->table . '.level', '>=', intval($filters['min_level']));
            })
            ->when(!empty($filters['start_year']), function ($query) use ($filters) {
                $query->where($this->table . '.start_year', '=', intval($filters['start_year']));
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['type_id']), function ($query) use ($filters) {
                $query->where($this->table . '.type_id', '=', intval($filters['type_id']));
            })
            ->when(!empty($filters['version']), function ($query) use ($filters) {
                $query->where($this->table . '.version', 'like', '%' . $filters['version'] . '%');
            })
            ->when(!empty($filters['years']), function ($query) use ($filters) {
                $query->where($this->table . '.years', '=', intval($filters['years']));
            })
            ->when(!empty($filters['min_years']), function ($query) use ($filters) {
                $query->where($this->table . '.years', '>=', intval($filters['min_years']));
            });

        $query->join( dbName('dictionary_db') . '.categories', 'categories.id', '=', $this->table . '.dictionary_category_id');

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // join to owner
        $query = $this->addJoinToAdminTable(
            $query,
            'portfolio_db',
            [ DB::raw('categories.name AS `dictionary_category_name`') ]
        );

        // add order by clause
        $query = $this->addOrderBy($query, $sort);
        if (explode('|', $sort ?? '') != 'owner_username') {
            $query->orderBy('owner_username');
        }

        return $query;
    }

    /**
     * Get the system owner of the skill.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the dictionary category that owns the skill.
     */
    public function category(): BelongsTo
    {
        return $this->setConnection('dictionary_db')->belongsTo(
            Category::class, 'dictionary_category_id'
        );
    }
}
