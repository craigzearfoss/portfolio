<?php

namespace App\Models\System;

use App\Models\Career\Application;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\Note;
use App\Models\Career\Reference;
use App\Models\Career\Resume;
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
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

    protected $table = 'admins';

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'username', 'name', 'city', 'state_id', 'zip', 'country_id', 'phone', 'email',
        'status', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['username', 'asc'];

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
     * Get the applications owners.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the art owners.
     */
    public function art(): HasMany
    {
        return $this->hasMany(Art::class);
    }

    /**
     * Get the certifications owners.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the communications owners.
     */
    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    /**
     * Get the companies owners.
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Get the contacts owners.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the courses owners.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the cover letters owners.
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
     * Get the events owners.
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
     * Get the links owners.
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Get the music owners.
     */
    public function music(): HasMany
    {
        return $this->hasMany(Music::class);
    }

    /**
     * Get the notes owners.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the projects owners.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the readings owners.
     */
    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }

    /**
     * Get the readings owners.
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Get the reading ingredients owners.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Get the reading steps owners.
     */
    public function recipeSteps(): HasMany
    {
        return $this->hasMany(RecipeStep::class);
    }

    /**
     * Get the references owners.
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
     * Get the resumes owners.
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
     * Get the videos owners.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
