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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class AntiSkill extends Model
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
    protected $table = 'anti_skills';

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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email',
        'dictionary_category_name'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'version', 'featured', 'summary', 'type_id', 'level',
        'dictionary_category_id', 'start_year', 'end_year', 'years', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'level', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'dictionary_category_name|asc' => 'category',
        'created_at|desc'              => 'datetime created',
        'updated_at|desc'              => 'datetime updated',
        'is_demo|desc'                 => 'demo',
        'is_disabled|desc'             => 'disabled',
        'featured|desc'                => 'featured',
        'id|asc'                       => 'id',
        'level|desc'                   => 'level',
        'name|asc'                     => 'name',
        'owner_id|asc'                 => 'owner id',
        'owner_name|asc'               => 'owner name',
        'owner_username|asc'           => 'owner username',
        'is_public|desc'               => 'public',
        'is_readonly|desc'             => 'read-only',
        'is_root|desc'                 => 'root',
        'sequence|asc'                 => 'sequence',
        'end_year|asc'                 => 'year ended',
        'start_year|asc'               => 'year started',
        'years|desc'                   => 'years',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'dictionary_category_name', 'is_disabled', 'level', 'name', 'is_public', 'years', ],
        'guest' => [ 'dictionary_category_name', 'level', 'name', 'years', ],
    ];

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

        $query = $this->getSearchQuery($filters, $owner)
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
                $query->where($this->table . '.level', '=', intval($filters['level']));
            })
            ->when(!empty($filters['level-max']), function ($query) use ($filters) {
                $query->where($this->table . '.level', '<=', intval($filters['level-max']));
            })
            ->when(!empty($filters['level-min']), function ($query) use ($filters) {
                $query->where($this->table . '.level', '>=', intval($filters['level-min']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
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
            ->when(!empty($filters['years-min']), function ($query) use ($filters) {
                $query->where($this->table . '.years', '>=', intval($filters['years-min']));
            });

        // join to dictionary.categories table
        $query->join( dbName('dictionary_db') . '.categories', 'categories.id', '=', $this->table . '.dictionary_category_id')
            ->addSelect(DB::Raw('categories.name as dictionary_category_name'));

        $query->with('owner', 'category');

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
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

    /**
     * Returns the collection of anti-skills for the owner.
     *
     * @param $ownerId
     * @return Collection
     */
    public static function ownerSkills($ownerId): Collection
    {
        return AntiSkill::query()->where('owner_id', $ownerId)->get();
    }

    /**
     * Returns an array of the user's portfolio.job_anti_skills that are found in the application description column.
     * By default, it only returns the anti-skills that are found. To return all the job anti-skills in the array, set
     * the $includeAll parameter to true.
     *
     * If no $adminId is specified then the owner_id of the application will be used.
     *
     * @param array $skills
     * @param string $description
     * @return array
     */
    public static function parseSkills(array $skills, string $description): array
    {
        if (empty($skills) || empty($description)) {
            return [ [], '' ];
        }

        $foundSkills = [];
        foreach ($skills as $slug=>$skill) {

            $skill = trim($skill);

            $found = false;

            if (stripos($description, $skill) !== false) {
                $found = true;
                $description = str_ireplace($skill, '<strong class="has-text-danger">' . $skill . '</strong>', $description);
            }

            /*
            if (rtrim($skill, '0...9') !==  $skill) {
                $skillNames[] = rtrim($skill, '0...9');
            }
            if (str_contains($skill, '.')) {
                if ($leftOfDot = strtok($skill, '.')) {
                    $skills[] = $leftOfDot;
                }
            }
            if (str_contains($skill, ' ')) {
                $skillNames[] = strtok($skill, ' ');
            }

            if ($skill === 'postgresql') {
                $skillNames[] = 'postgres';
            }
            if ($skill === 'aws') {
                $skillNames[] = 'amazon web services';
            }
            if ($skill === 'amazon web services') {
                $skillNames[] = 'aws';
            }

            if (stripos($description, $skill) !== false) {
                $foundSkills[] = $skill;
                str_ireplace()re
            } else {

            }

            // account for slight variations of terms
            $skillNames = [ $skillName ];
            if (rtrim($skillName, '0...9') !==  $skillName) $skillNames[] = rtrim($skillName, '0...9');
            if (str_contains($skillName, '.')) {
                $skillNames[] = strtok($skillName, '.');
            }
            if (str_contains($skillName, ' ')) {
                $skillNames[] = strtok($skillName, ' ');
            }

            if ($skillName === 'postgresql') $skillNames[] = 'postgres';
            if ($skillName === 'aws') $skillNames[] = 'amazon web services';
            if ($skillName === 'amazon web services') $skillNames[] = 'aws';

            foreach ($skillNames as $skillName) {
                if (str_contains($textOrHTML, $skillName)) {
                    $skills[$slug]['found'] = 1;
                    break;
                }
            }
            */

            if ($found) {
                $foundSkills[] = $skill;
            }
        }

        return [
            $foundSkills,
            $description,
        ];
    }
}
