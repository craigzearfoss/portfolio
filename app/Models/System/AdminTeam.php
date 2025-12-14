<?php

namespace App\Models\System;

use App\Models\System\AdminAdminTeam;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AdminTeam extends Model
{
    /** @use HasFactory<\Database\Factories\AdminTeamFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'system_db';

    protected $table = 'admin_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'abbreviation',
        'description',
        'image',
        'thumbnail',
        'logo',
        'logo_small',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'abbreviation', 'public', 'readonly', 'root', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the owner of the admin team.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the admin groups for the admin team.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(AdminGroup::class);
    }


    /**
     * Get the admin groups for the admin team.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(AdminGroup::class);
    }

    /**
     * Get the admins for the admin team.
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class)->orderBy('name', 'asc');
    }

    /**
     * Returns the members of the admin team.
     *
     * @return Collection
     */
    public function members(): Collection
    {
        return AdminAdminTeam::select('admins.*')
            ->where('admin_admin_team.admin_team_id', $this->id)
            ->join('admins', 'admins.id', '=', 'admin_admin_team.admin_id')
            ->get();
    }
}
