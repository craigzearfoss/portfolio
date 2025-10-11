<?php

namespace App\Models\System;

use App\Models\Scopes\AdminGlobalScope;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AdminGroup extends Model
{
    /** @use HasFactory<\Database\Factories\AdminGroupFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'core_db';

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
        'disabled',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'admin_team_id', 'name', 'abbreviation'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

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
        return $this->setConnection('core_db')->belongsTo(AdminTeam::class, 'admin_team_id');
    }
}
