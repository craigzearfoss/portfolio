<?php

namespace App\Models\System;

use App\Enums\EnvTypes;
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
use App\Traits\SearchableModelTrait;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Admin extends Authenticatable
{
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_team_id',
        'username',
        'label',
        'name',
        'salutation',
        'title',
        'role',
        'employer',
        'employment_status_id',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'phone',
        'email',
        'birthday',
        'link',
        'link_name',
        'bio',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
        'password',
        'remember_token',
        'token',
        'requires_relogin',
        'status',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *
     */
    const array STATUSES = [
        'pending',
        'active',
    ];

    /**
     *
     */
    const array SALUTATIONS = [
        'Dr.',
        'Miss',
        'Mr.',
        'Mrs.',
        'Ms',
        'Prof.',
        'Rev.',
        'Sir',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'admin_team_id', 'username', 'name', 'label', 'salutation', 'title', 'role',
        'street', 'street2', 'city', 'state_id', 'zip', 'country_id', 'phone', 'email', 'status', 'public', 'readonly',
        'root', 'disabled', 'demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'username', 'asc' ];


    /**
     * Returns an array of options for a select list for salutations, i.e. Mr., Mrs., Miss, etc.
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public function salutationListOptions(bool $includeBlank = false): array
    {
        $options = $includeBlank ? [ '' => '' ] : [];

        foreach (self::SALUTATIONS as $title) {
            $options[$title] = $title;
        }

        return $options;
    }

    /**
     * Returns an array of options for a select list for statuses, i.e. active or pending.
     *
     * @param string $valueColumn - id or name
     * @return array|string[]
     */
    public function statusListOptions(string $valueColumn = 'id'): array
    {
        $options = [];

        foreach (self::STATUSES as $id=>$name) {
            $options[$valueColumn == 'id' ? $id : $name] = $name;
        }

        return $options;
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
                unset($filters['id']);
            }
            $filters['id'] = $owner->id;
        }

        $query = new self()->when(isset($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['username']), function ($query) use ($filters) {
                $query->where('username', 'like', '%' . $filters['username'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['label']), function ($query) use ($filters) {
                $query->where('label', 'like', '%' . $filters['label'] . '%');
            })
            ->when(!empty($filters['salutation']), function ($query) use ($filters) {
                $query->where('salutation', 'like', '%' . $filters['salutation'] . '%');
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->where('role', 'like', '%' . $filters['role'] . '%');
            })
            ->when(!empty($filters['employer']), function ($query) use ($filters) {
                $query->where('employer', 'like', '%' . $filters['employer'] . '%');
            })
            ->when(isset($filters['employment_status_id']), function ($query) use ($filters) {
                $query->where('employment_status_id', '=', intval($filters['employment_status_id']));
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where('city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where('state_id', '=', intval($filters['state_id']));
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where('country_id', '=', intval($filters['country_id']));
            })
            ->when(!empty($filters['phone']), function ($query) use ($filters) {
                $query->where('phone', 'LIKE', '%' . $filters['phone'] . '%');
            })
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $query->where('email', 'LIKE', '%' . $filters['email'] . '%');
            })
            ->when(!empty($filters['birthday']), function ($query) use ($filters) {
                $query->where('birthday', '=',  $filters['birthday']);
            })
            ->when(isset($filters['requires_relogin']), function ($query) use ($filters) {
                $query->where('requires_relogin', '=', boolval($filters['requires_relogin']));
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                $query->where('status', '=', boolval($filters['status']));
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system admin_databases for the owner.
     *
     * @return HasOne
     */
    public function adminDatabases(): HasOne
    {
        return $this->hasOne(AdminDatabase::class, 'owner_id');
    }

    /**
     * Get the system admin_resources for the owner.
     *
     * @return HasMany
     */
    public function adminResources(): HasMany
    {
        return $this->hasMany(AdminResource::class, 'owner_id');
    }

    /**
     * Get the career applications for the owner.
     *
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Application::class, 'owner_id');
    }

    /**
     * Get the portfolio art for the owner.
     *
     * @return HasMany
     */
    public function art(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Art::class, 'owner_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the portfolio certificates for the owner.
     *
     * @return HasMany
     */
    public function certificates(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Certificate::class, 'owner_id');
    }

    /**
     * Get the career communications for the owner.
     *
     * @return HasMany
     */
    public function communications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Communication::class, 'owner_id');
    }

    /**
     * Get the career companies for the owner.
     *
     * @return HasMany
     */
    public function companies(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Company::class, 'owner_id');
    }

    /**
     * Get the career contacts for the owner.
     *
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Contact::class, 'owner_id');
    }

    /**
     * Get the system country that owns the admin.
     *
     * @return HasMany
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the portfolio courses for the owner.
     *
     * @return HasMany
     */
    public function courses(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Course::class, 'owner_id');
    }

    /**
     * Get the career cover letters for the owner.
     *
     * @return HasMany
     */
    public function coverLetters(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(CoverLetter::class, 'owner_id');
    }

    /**
     * Get the system databases for the owner.
     *
     * @return HasMany
     */
    public function databases(): HasMany
    {
        return $this->hasMany(Database::class, 'owner_id');
    }

    /**
     * Get the career educations for the owner.
     *
     * @return HasMany
     */
    public function educations(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Education::class, 'owner_id');
    }

    /**
     * Get the system employment status that owns the admin.
     *
     * @return BelongsTo
     */
    public function employmentStatus(): BelongsTo
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_status_id');
    }

    /**
     * Get the career events for the owner.
     *
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Event::class, 'owner_id');
    }

    /**
     * Get all the system admingroups for the admin.
     *
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(AdminGroup::class)
            ->orderBy('name');
    }

    /**
     * Get the portfolio jobs for the owner.
     *
     * @return HasMany
     */
    public function jobs(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Job::class, 'owner_id');
    }

    /**
     * Get the portfolio job coworkers for the owner.
     *
     * @return HasMany
     */
    public function jobCoworkers(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(JobCoworker::class, 'owner_id');
    }

    /**
     * Get the portfolio job tasks for the owner.
     *
     * @return HasMany
     */
    public function jobTasks(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(JobTask::class, 'owner_id');
    }

    /**
     * Get the portfolio links for the owner.
     *
     * @return HasMany
     */
    public function links(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Link::class, 'owner_id');
    }

    /**
     * Get the portfolio music for the owner.
     *
     * @return HasMany
     */
    public function music(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Music::class, 'owner_id');
    }

    /**
     * Get the career notes for the owner.
     *
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Note::class, 'owner_id');
    }

    /**
     * Get the portfolio projects for the owner.
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Project::class, 'owner_id');
    }

    /**
     * Get the personal readings for the owner.
     *
     * @return HasMany
     */
    public function readings(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(Reading::class, 'owner_id');
    }

    /**
     * Get the personal recipes for the owner.
     *
     * @return HasMany
     */
    public function recipes(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(Recipe::class, 'owner_id');
    }

    /**
     * Get the personal recipe ingredients for the owner.
     *
     * @return HasMany
     */
    public function recipeIngredients(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(RecipeIngredient::class, 'owner_id');
    }

    /**
     * Get the personal recipe steps for the owner.
     *
     * @return HasMany
     */
    public function recipeSteps(): HasMany
    {
        return $this->setConnection('personal_db')->hasMany(RecipeStep::class, 'owner_id');
    }

    /**
     * Get the career references for the owner.
     *
     * @return HasMany
     */
    public function references(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Reference::class, 'owner_id');
    }

    /**
     * Get the system resources for the owner.
     *
     * @return HasMany
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class, 'owner_id');
    }

    /**
     * Get the career resumes for the owner.
     *
     * @return HasMany
     */
    public function resumes(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Resume::class, 'owner_id');
    }

    /**
     * Returns the id for the given salutation or false if not found.
     *
     * @param string $name
     * @return int|bool
     */
    public static function salutationIndex(string $name): int|bool
    {
        return array_search($name, self::SALUTATIONS);
    }

    /**
     * Returns the salutation name for the given id or null if not found.
     *
     * @param int $id
     * @return string|null
     */
    public static function salutationName(int $id): string|null
    {
        return self::SALUTATIONS[$id] ?? null;
    }

    /**
     * Get the portfolio skills for the owner.
     *
     * @return HasMany
     */
    public function skills(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Skill::class, 'owner_id');
    }

    /**
     * Get the system state that owns the admin.
     *
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Returns the id for the given status or false if not found.
     *
     * @param string $name
     * @return int|bool
     */
    public static function statusIndex(string $name): int|bool
    {
        return array_search($name, self::STATUSES);
    }

    /**
     * Returns the status name for the given id or null if not found.
     *
     * @param int $id
     * @return string|null
     */
    public static function statusName(int $id): string|null
    {
        return self::STATUSES[$id] ?? null;
    }

    /**
     * Get the current system admin team of the admin.
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(AdminTeam::class, 'admin_team_id');
    }

    /**
     * Get all the system admin teams for the admin.
     *
     * @return BelongsToMany
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(AdminTeam::class)
            ->orderBy('name');
    }

    /**
     * Get the portfolio videos for the owner.
     *
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(Video::class, 'owner_id');
    }
}
