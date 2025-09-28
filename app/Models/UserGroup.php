<?php

namespace App\Models;

use App\Models\Owner;
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
        'owner_id',
        'user_team_id',
        'name',
        'slug',
        'abbreviation',
        'description',
        'disabled',
    ];

    /**
     * Get the owner of the user group.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Owner::class, 'owner_id');
    }

    /**
     * Get the admin who owns the user group.
     */
    public function team(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(UserTeam::class, 'user_team_id');
    }

    /**
     * Returns an array of options for a user group select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       bool $includeBlank = false,
                                       bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[$nameAsKey ? '' : 0] = '';
        }

        $query = self::select('id', 'name')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $userGroup) {
            $options[$nameAsKey ? $userGroup->name : $userGroup->id] = $userGroup->name;
        }

        return $options;
    }
}
