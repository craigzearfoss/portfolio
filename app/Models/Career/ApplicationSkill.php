<?php

namespace App\Models\Career;

use App\Models\Portfolio\Skill;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Str;

/**
 *
 */
class ApplicationSkill extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'application_skills';

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
        'owner_id',
        'application_id',
        'name',
        'level',
        'dictionary_category_id',
        'dictionary_term_id',
        'start_year',
        'end_year',
        'years',
        'notes',
        'description',
        'disclaimer',
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
    const array SEARCH_COLUMNS = [ 'owner_id', 'application_id', 'name', 'level', 'dictionary_category_id',
        'dictionary_term_id', 'start_year', 'end_year', 'years', 'notes', 'description', 'disclaimer', 'is_public',
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
        //'application_id|asc'           => 'application id',
        'created_at|desc'              => 'datetime created',
        'updated_at|desc'              => 'datetime updated',
        'is_demo|desc'                 => 'demo',
        'dictionary_category_name|asc' => 'dictionary category',
        'dictionary_tern_name|asc'     => 'dictionary term',
        'is_disabled|desc'             => 'disabled',
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
        'year_ended|desc'              => 'year ended',
        'year_started|desc'            => 'year started',
        'years|desc'                   => 'years',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'level', 'name', 'year_started', 'year_ended', 'years' ],
        'guest' => [ 'level', 'name', 'year_started', 'year_ended', 'years' ],
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
     * @TODO: Need to add joins for company_ids to be searched.
     *
     * @param array $filters
     * @param string|null $sort
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
            ->when(!empty($filters['application_id']), function ($query) use ($filters) {
                $query->where($this->table . '.application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where($this->table . '.dictionary_category_id', '=', intval($filters['dictionary_category_id']));
            })
            ->when(!empty($filters['dictionary_term_id']), function ($query) use ($filters) {
                $query->where($this->table . '.dictionary_term_id', '=', intval($filters['dictionary_term_id']));
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['end_year']), function ($query) use ($filters) {
                $query->where($this->table . '.end_year', '<=', intval($filters['end_year']));
            })
            ->when(!empty($filters['level']), function ($query) use ($filters) {
                $query->where($this->table . '.level', '=', intval($filters['level']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['start_year']), function ($query) use ($filters) {
                $query->where($this->table . '.start_year', '<=', $filters['start_year']);
            })
            ->when(!empty($filters['years']), function ($query) use ($filters) {
                $query->where($this->table . '.years', '=', intval($filters['years']));
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query =  $this->appendTimestampFilters($query, $filters);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the application skill.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application of the application skill.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public static function jobSkills($ownerId): Collection
    {
        return Skill::query()->where('owner_id', $ownerId)->get();
    }

    /**
     * Returns an array of the user's portfolio.job_skills that are found in the application description column.
     * By default, it only returns the skills that are found. To return all the job skills in the array, set the
     * $includeAll parameter to true.
     *
     * If no $adminId is specified then the owner_id of the application will be used.
     *
     * @param Application $application
     * @param bool $includeAll
     * @param int|null $adminId
     * @return array
     */
    public static function parseSkills(Application $application, bool $includeAll = false, int|null $adminId = null): array
    {
        if (!$textOrHTML = $application['description']) {
            return [];
        }

        // get the id of the admin/owner
        $adminId = !empty($adminId) ? $adminId : $application['owner_id'];

        // get the skills from the portfolio skills table
        $skills = [];
        foreach (self::jobSkills($adminId) as $jobSkill) {

            $slug = Str::slug($jobSkill->name);

            $skill = [
                'id'                     => null,
                'owner_id'               => $application['owner_id'],
                'application_id'         => $application['id'],
                'name'                   => $jobSkill->name,
                'slug'                   => $slug,
                'type_id'                => null,
                'level'                  => -1,
                'dictionary_category_id' => $jobSkill->dictionary_category_id,
                'found'                  => false,
            ];

            $skills[$slug] = $skill;
        }

        // string html tags from text and convert to lowercase
        $textOrHTML = strtolower(strip_tags($textOrHTML));

        foreach ($skills as $slug=>$skill) {

            $skillName = strtolower($skill['name']);

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
        }

        if (!$includeAll) {
            $skills = array_filter($skills, function ($skill) {
                return $skill['found'];
            });
        }

        return array_values($skills);
    }

    /**
     * Adds an application skill into the database. If the skill already exists in the database then it
     * will remain unchanged.
     *
     * @param Application $application
     * @param array $skill
     * @return bool
     */
    public function addSkill(Application $application, array $skill): bool
    {
        if (!$skillName = $skill['name'] ?? null) {
            return false;
        }

        // verify that the skill isn't already associated with the application
        if (ApplicationSkill::query()
            ->where('application_id', $application['id'])
            ->where('owner_id', $application['owner_id'])
            ->where('name', $skillName)->first()
        ) {
            return true;
        }

        // add the skill to the database
        $applicationSkill = new ApplicationSkill();
        $applicationSkill['owner_id']               = $application['owner_id'];
        $applicationSkill['application_id']         = $application['id'];
        $applicationSkill['name']                   = $skillName;
        $applicationSkill['level']                  = $application['level'] ?? -1;
        $applicationSkill['dictionary_category_id'] = $application['dictionary_category_id'] ?? null;
        $applicationSkill['dictionary_term_id']     = $application['dictionary_term_id'] ?? null;

        if (!$applicationSkill->save()) {
            return false;
        }

        return true;
    }

    /**
     * Adds an array of application skills into the database. If they already exist in the database they
     * will remain unchanged.
     *
     * @param Application $application
     * @param array $skills
     * @return bool
     */
    public function addSkills(Application $application, array $skills): bool
    {
        $retVal = true;
        foreach ($skills as $skill) {
            if (!$this->addSkill($application, $skill)) {
                $retVal = false;
            }
        }

        return $retVal;
    }

    public function removeSkill(int $applicationSkillId): bool
    {
        if (self::query()->where('id', $applicationSkillId)->delete()) {
            return true;
        } else {
            return false;
        }
    }
}
