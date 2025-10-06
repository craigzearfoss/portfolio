<?php

namespace App\Models;

use App\Models\Country;
use App\Models\State;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

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
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'username', 'name', 'city', 'state_id', 'zip', 'country_id', 'phone', 'email',
        'status', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['username', 'asc'];

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
}
