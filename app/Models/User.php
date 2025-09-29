<?php

namespace App\Models;

use App\Models\Country;
use App\Models\State;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'core_db';

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_team_id',
        'username',
        'name',
        'title',
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
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'password',
        'remember_token',
        'token',
        'status',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
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

    const STATUSES = [
        'pending',
        'active',
    ];

    const TITLES = [
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
     * Get the country that owns the user.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the state that owns the user.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(State::class, 'state_id');
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
     * Returns the status name for the given id or null if not found.
     *
     * @param int $id
     * @return string|null
     */
    public static function statusName(int $id): string | null
    {
        return self::STATUSES[$id] ?? null;
    }

    /**
     * Returns the status id for the giving name or false if not found.
     *
     * @param string $name
     * @return int|bool
     */
    public static function statusIndex(string $name): string |bool
    {
        return array_search($name, self::STATUSES);
    }

    /**
     * Returns the title name for the given id or null if not found.
     *
     * @param int $id
     * @return string|null
     */
    public static function titleName(int $id): string | null
    {
        return self::TITLES[$id] ?? null;
    }

    /**
     * Returns the title id for the giving name or false if not found.
     *
     * @param string $name
     * @return int|bool
     */
    public static function titleIndex(string $name): string |bool
    {
        return array_search($name, self::TITLES);
    }

    /**
     * Returns an array of options for a select list for statuses.
     *
     * @param array $filters (Not used but included to keep signature consistent with other listOptions methods.)
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function statusListOptions(array $filters = [],
                                             bool $includeBlank = false,
                                             bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        foreach (self::STATUSES as $i=>$status) {
            $options[$nameAsKey ? $status : $i] = $status;
        }

        return $options;
    }

    /**
     * Returns an array of options for a select list for title.
     *
     * @param array $filters    (Not used but included to keep signature consistent with other listOptions methods.)
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function titleListOptions(array $filters = [],
                                            bool $includeBlank = false,
                                            bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[$nameAsKey ? '' : 0] = '';
        }

        foreach (self::TITLES as $i=>$title) {
            $options[$nameAsKey ? $title : $i] = $title;
        }

        return $options;
    }
}
