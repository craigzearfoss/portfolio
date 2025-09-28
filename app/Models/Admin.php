<?php

namespace App\Models;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'core_db';

    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_team_id',
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
     * Get the country that owns the admin.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the state that owns the admin.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param array $filters
     * @param bool $usernameAsKey
     * @param bool $includeNames
     * @return array|string[]
     * @param bool $includeBlank
     */
    public static function listOptions(
        array $filters = [],
        bool $includeBlank = false,
        bool $usernameAsKey = false,
        bool $includeNames = false,
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
