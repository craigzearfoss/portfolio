<?php

namespace App\Models;

use app\Models\Admin;
use App\Models\UserTeam;
use App\Models\UserTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserGroup extends Model
{
    /** @use HasFactory<\Database\Factories\UserGroupFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'core_db';

    protected $table = 'user_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'user_team_id',
        'name',
        'slug',
        'abbreviation',
        'description',
        'disabled',
    ];

    /**
     * Get the admin who owns the user group.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin::class);
    }

    /**
     * Get the user team that owns the user group.
     */
    public function team(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(UserTeam::class, 'user_team_id');
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

        foreach (UserGroup::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
