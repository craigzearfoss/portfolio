<?php

namespace App\Models;

use App\Models\AdminGroup;
use App\Models\AdminTeam;
use App\Models\Career\Application;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\Note;
use App\Models\Career\Reference;
use App\Models\Career\Resume;
use App\Models\Database;
use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Certification;
use App\Models\Portfolio\Course;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use App\Models\Portfolio\JobTask;
use App\Models\Portfolio\Link;
use App\Models\Portfolio\Music;
use App\Models\Portfolio\Project;
use App\Models\Portfolio\Skill;
use App\Models\Portfolio\Video;
use App\Models\Resource;
use App\Models\UserGroup;
use App\Models\UserTeam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    protected $connection = 'core_db';

    protected $table = 'admins';

    /**
     * Get the admin groups owners.
     */
    public function adminGroups(): HasMany
    {
        return $this->hasMany(AdminGroup::class);
    }

    /**
     * Get the admin teams owners.
     */
    public function adminTeams(): HasMany
    {
        return $this->hasMany(AdminTeam::class);
    }

    /**
     * Get the career applications owners.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the portfolio art owners.
     */
    public function art(): HasMany
    {
        return $this->hasMany(Art::class);
    }

    /**
     * Get the portfolio certifications owners.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the career communications owners.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    /**
     * Get the career companies owners.
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Get the career contacts owners.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the portfolio courses owners.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the career cover letters owners.
     */
    public function coverLetters(): HasMany
    {
        return $this->hasMany(CoverLetter::class);
    }

    /**
     * Get the databases owners.
     */
    public function databases(): HasMany
    {
        return $this->hasMany(Database::class);
    }

    /**
     * Get the career events owners.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the career jobs owners.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the career job coworkers owners.
     */
    public function jobCoworkers(): HasMany
    {
        return $this->hasMany(JobCoworker::class);
    }

    /**
     * Get the career job tasks owners.
     */
    public function jobTasks(): HasMany
    {
        return $this->hasMany(JobTask::class);
    }

    /**
     * Get the portfolio links owners.
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Get the portfolio music owners.
     */
    public function music(): HasMany
    {
        return $this->hasMany(Music::class);
    }

    /**
     * Get the career notes owners.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the portfolio projects owners.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the personal readings owners.
     */
    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }

    /**
     * Get the personal recipes owners.
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Get the personal recipe ingredients owners.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Get the personal recipe steps owners.
     */
    public function recipeSteps(): HasMany
    {
        return $this->hasMany(RecipeStep::class);
    }

    /**
     * Get the career references owners.
     */
    public function references(): HasMany
    {
        return $this->hasMany(Reference::class);
    }

    /**
     * Get the resources owners.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the career resumes owners.
     */
    public function resumes(): HasMany
    {
        return $this->hasMany(Resume::class);
    }

    /**
     * Get the career skills owners.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Get the user groups owners.
     */
    public function userGroups(): HasMany
    {
        return $this->hasMany(UserGroup::class);
    }

    /**
     * Get the user teams owners.
     */
    public function userTeams(): HasMany
    {
        return $this->hasMany(UserTeam::class);
    }

    /**
     * Get the portfolio videos owners.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $usernameAsKey
     * @param bool $includeNames
     * @return array|string[]
     */
    public static function listOptions(
        array $filters = [],
        bool $includeBlank = false,
        bool $usernameAsKey = false,
        bool $includeNames = false
    ): array
    {
        $options = [];
        if ($includeBlank) {
            $options[$usernameAsKey ? '' : 0] = '';
        }

        $query = self::orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $row) {
            $options[$usernameAsKey ? $row->username : $row->id] = $includeNames
                ? $row->username . (!empty($row->name) ? ' (' . $row->name . ')' : '')
                : $row->username;
        }

        return $options;
    }
}
