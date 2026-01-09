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
use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\Course;
use App\Models\Portfolio\Education;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use App\Models\Portfolio\JobTask;
use App\Models\Portfolio\Link;
use App\Models\Portfolio\Music;
use App\Models\Portfolio\Project;
use App\Models\Portfolio\Skill;
use App\Models\Portfolio\Video;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Owner extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

    protected $table = 'admins';

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'admin_team_id', 'username', 'name', 'title', 'street', 'street2', 'city',
        'state_id', 'zip', 'country_id', 'phone', 'email', 'status', 'public', 'readonly', 'root', 'disabled',
        'demo'];
    const SEARCH_ORDER_BY = ['username', 'asc'];

    /**
     * Get the system admin_databases for the owner.
     */
    public function adminDatabases(): HasOne
    {
        return $this->hasOne(AdminDatabase::class, 'owner_id');
    }

    /**
     * Get the system admin_resources for the owner.
     */
    public function adminResources(): HasOne
    {
        return $this->hasOne(AdminResource::class, 'owner_id');
    }

    /**
     * Get the system admin groups for the owner.
     */
    public function adminGroups(): HasMany
    {
        return $this->hasMany(AdminGroup::class, 'owner_id');
    }

    /**
     * Get the system admin teams for the owner.
     */
    public function adminTeams(): HasMany
    {
        return $this->hasMany(AdminTeam::class, 'owner_id');
    }

    /**
     * Get the career applications for the owner.
     */
    public function applications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Application::class, 'owner_id');
    }

    /**
     * Get the portfolio art for the owner.
     */
    public function art(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Art::class, 'owner_id');
    }

    /**
     * Get the portfolio certificates for the owner.
     */
    public function certificates(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Certificate::class, 'owner_id');
    }

    /**
     * Get the career communications for the owner.
     */
    public function communications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Communication::class, 'owner_id');
    }

    /**
     * Get the career companies for the owner.
     */
    public function companies(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Company::class, 'owner_id');
    }

    /**
     * Get the career contacts for the owner.
     */
    public function contacts(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Contact::class, 'owner_id');
    }

    /**
     * Get the portfolio courses for the owner.
     */
    public function courses(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Course::class, 'owner_id');
    }

    /**
     * Get the career cover letters for the owner.
     */
    public function coverLetters(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(CoverLetter::class, 'owner_id');
    }

    /**
     * Get the system databases for the owner.
     */
    public function databases(): HasMany
    {
        return $this->hasMany(Database::class, 'owner_id');
    }

    /**
     * Get the career educations for the owner.
     */
    public function educations(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Education::class, 'owner_id');
    }

    /**
     * Get the career events for the owner.
     */
    public function events(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Event::class, 'owner_id');
    }

    /**
     * Get the portfolio jobs for the owner.
     */
    public function jobs(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Job::class, 'owner_id');
    }

    /**
     * Get the portfolio job coworkers for the owner.
     */
    public function jobCoworkers(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(JobCoworker::class, 'owner_id');
    }

    /**
     * Get the portfolio job tasks for the owner.
     */
    public function jobTasks(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(JobTask::class, 'owner_id');
    }

    /**
     * Get the portfolio links for the owner.
     */
    public function links(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Link::class, 'owner_id');
    }

    /**
     * Get the portfolio music for the owner.
     */
    public function music(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Music::class, 'owner_id');
    }

    /**
     * Get the career notes for the owner.
     */
    public function notes(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Note::class, 'owner_id');
    }

    /**
     * Get the portfolio projects for the owner.
     */
    public function projects(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Project::class, 'owner_id');
    }

    /**
     * Get the personal readings for the owner.
     */
    public function readings(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(Reading::class, 'owner_id');
    }

    /**
     * Get the personal recipes for the owner.
     */
    public function recipes(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(Recipe::class, 'owner_id');
    }

    /**
     * Get the personal recipe ingredients for the owner.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(RecipeIngredient::class, 'owner_id');
    }

    /**
     * Get the personal recipe steps for the owner.
     */
    public function recipeSteps(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(RecipeStep::class, 'owner_id');
    }

    /**
     * Get the career references for the owner.
     */
    public function references(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Reference::class, 'owner_id');
    }

    /**
     * Get the system resources for the owner.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class, 'owner_id');
    }

    /**
     * Get the career resumes for the owner.
     */
    public function resumes(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Resume::class, 'owner_id');
    }

    /**
     * Get the portfolio skills for the owner.
     */
    public function skills(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Skill::class, 'owner_id');
    }

    /**
     * Get the system user groups for the owner.
     */
    public function userGroups(): HasMany
    {
        return $this->hasMany(UserGroup::class, 'owner_id');
    }

    /**
     * Get the system user teams for the owner.
     */
    public function userTeams(): HasMany
    {
        return $this->hasMany(UserTeam::class, 'owner_id');
    }

    /**
     * Get the portfolio videos for the owner.
     */
    public function videos(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Video::class, 'owner_id');
    }
}
