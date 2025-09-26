<?php

namespace App\Models;

use app\Models\Admin;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserTeam extends Model
{
    /** @use HasFactory<\Database\Factories\UserTeamFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'core_db';

    protected $table = 'user_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'name',
        'abbreviation',
        'slug',
        'description',
        'disabled',
    ];

    /**
     * Get the admin who owns the user team.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin::class);
    }

    /**
     * Get the user groups for the user team.11
     */
    public function groups(): hasMany
    {
        return $this->hasMany(UserGroup::class);
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

        foreach (UserTeam::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
