<?php

namespace App\Models\System;

use App\Models\System\User as UserModel;
use App\Observers\System\UserObserver;
use App\Traits\SearchableModelTrait;
use Database\Factories\System\UserFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 *
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'user_team_id',
        'username',
        'name',
        'label',
        'salutation',
        'title',
        'role',
        'employer',
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
        'email_verified_at',
        'birthday',
        'bio',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
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
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
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
    const array SEARCH_COLUMNS = [ 'id', 'user_id', 'user_team_id', 'username', 'name', 'label', 'salutation', 'title',
        'role', 'employer', 'street', 'street2', 'city', 'state_id', 'zip', 'country_id', 'phone', 'email', 'birthday',
        'bio', 'notes', 'description', 'disclaimer', 'requires_relogin', 'status', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'username', 'asc' ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [];
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
            ->when(!empty($filters['bio']), function ($query) use ($filters) {
                $query->where($this->table . '.bio', 'like', '%' . $filters['bio'] . '%');
            })
            ->when(!empty($filters['birthday']), function ($query) use ($filters) {
                $query->where($this->table . '.birthday', '=', $filters['birthday']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $query->where($this->table . '.email', 'like', '%' . $filters['email'] . '%');
            })
            ->when(!empty($filters['employer']), function ($query) use ($filters) {
                $query->where($this->table . '.employer', 'like', '%' . $filters['employer'] . '%');
            })
            ->when(!empty($filters['label']), function ($query) use ($filters) {
                $query->where($this->table . '.label', 'like', '%' . $filters['label'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['phone']), function ($query) use ($filters) {
                $query->where($this->table . '.phone', 'like', '%' . $filters['phone'] . '%');
            })
            ->when(!empty($filters['requires_relogin']), function ($query) use ($filters) {
                $query->where($this->table . '.requires_relogin', '=', true);
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->where($this->table . '.role', 'like', '%' . $filters['role'] . '%');
            })
            ->when(!empty($filters['salutation']), function ($query) use ($filters) {
                $query->where($this->table . '.salutation', 'like', '%' . $filters['salutation'] . '%');
            })
            ->when(!empty($filters['status']), function ($query) use ($filters) {
                $query->where($this->table . '.status', '=', intval($filters['status']));
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(!empty($filters['username']), function ($query) use ($filters) {
                $query->where($this->table . '.username', 'like', '%' . $filters['username'] . '%');
            })
            ->when(!empty($filters['user_team_id']), function ($query) use ($filters) {
                $query->where($this->table . '.user_team_id', '=', intval($filters['user_team_id']));
            });

        $query = $this->appendAddressFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
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
     * Get the system country that owns the user.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get all the system user_groups for the user.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(UserGroup::class)
            ->orderBy('name');
    }

    /**
     * Get the system state that owns the user.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Returns the id for the given status or false if not found.
     *
     * @param string $name
     * @return string|int|bool
     */
    public static function statusIndex(string $name): string|int|bool
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
     * Get the current system user_team of the user.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(UserTeam::class, 'user_team_id');
    }

    /**
     * Get all the system user_teams for the user.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(UserTeam::class)
            ->orderBy('name');
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
     * @param bool $includeBlank
     * @return array|string[]
     */
    public function statusListOptions(bool $includeBlank = false): array
    {
        $options = $includeBlank ? [ '' => '' ] : [];

        foreach (self::STATUSES as $name) {
            $options[$name] = $name;
        }

        return $options;
    }
}
