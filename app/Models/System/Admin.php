<?php

namespace App\Models\System;

use App\Models\System\AdminTeam;
use App\Models\System\Country;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'system_db';

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
        'slautation',
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

    const SALUTATIONS = [
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
    const SEARCH_COLUMNS = ['id', 'admin_team_id', 'username', 'label', 'name', 'title', 'street', 'street2', 'city',
        'state_id', 'zip', 'country_id', 'phone', 'email', 'status', 'public', 'readonly', 'root', 'disabled',
        'demo'];
    const SEARCH_ORDER_BY = ['username', 'asc'];

    /**
     * Get the system country that owns the admin.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the system state that owns the admin.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the system team of the admin.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(AdminTeam::class, 'admin_team_id');
    }

    /**
     * Get all the teams for the admin.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(AdminTeam::class)->orderBy('name', 'asc');
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
     * Returns the salutation id for the giving name or false if not found.
     *
     * @param string $name
     * @return int|bool
     */
    public static function salutationIndex(string $name): string |bool
    {
        return array_search($name, self::SALUTATIONS);
    }

    /**
     * Returns an array of options for a select list for salutations, i.e. Mr., Mrs., Miss, etc.
     *
     * @param array $filters    (Not used but included to keep signature consistent with other listOptions methods.)
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function salutationListOptions(array $filters = [],
                                                 bool $includeBlank = false,
                                                 bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[$nameAsKey ? '' : 0] = '';
        }

        foreach (self::SALUTATIONS as $i=>$title) {
            $options[$nameAsKey ? $title : $i] = $title;
        }

        return $options;
    }
}
