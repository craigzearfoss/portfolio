<?php

namespace App\Models\System;

use App\Models\System\AdminAdminTeam;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AdminGroup extends Model
{
    /** @use HasFactory<\Database\Factories\AdminGroupFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'system_db';

    protected $table = 'admin_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'admin_team_id',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'admin_team_id', 'name', 'abbreviation', 'public', 'readonly', 'root',
        'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the owner of the admin group.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the admin team that owns the admin group.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(AdminTeam::class, 'admin_team_id');
    }

    /**
     * Returns the members of the admin group.
     *
     * @return Collection
     */
    public function members(): Collection
    {
        return AdminAdminGroup::select('admins.*')
            ->where('admin_admin_group.admin_group_id', $this->id)
            ->join('admins', 'admins.id', '=', 'admin_admin_group.admin_id')
            ->get();
    }
}
