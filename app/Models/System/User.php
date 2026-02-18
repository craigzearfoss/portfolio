<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
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
        'user_team_id',
        'username',
        'label',
        'name',
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
    const array SEARCH_COLUMNS = ['id', 'user_team_id', 'username', 'label', 'name', 'salutation', 'title', 'role', 'street',
        'street2', 'city', 'state_id', 'zip', 'country_id', 'phone', 'email', 'status', 'public', 'readonly', 'root',
        'disabled', 'demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['username', 'asc'];

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
            }
            $filters['owner_id'] = $owner->id;
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
