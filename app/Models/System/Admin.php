<?php

namespace App\Models\System;

use App\Models\System\AdminTeam;
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
}
