<?php

namespace App\Models;

use app\Models\Admin;
use App\Models\AdminGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AdminTeam extends Model
{
    /** @use HasFactory<\Database\Factories\AdminTeamFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'core_db';

    protected $table = 'admin_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'name',
        'slug',
        'abbreviation',
        'description',
        'disabled',
    ];

    /**
     * Get the admin who owns the admin group.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin::class);
    }

    /**
     * Get the admin groups for the admin team.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(AdminGroup::class);
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = $includeBlank
            ? $nameAsKey ? [ '' => '' ] :[ 0 => '' ]
            : [];

        foreach (AdminTeam::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
