<?php

namespace App\Models;

use app\Models\Admin;
use App\Models\AdminTeam;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AdminGroup extends Model
{
    /** @use HasFactory<\Database\Factories\AdminGroupFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'core_db';

    protected $table = 'admin_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'admin_team_id',
        'name',
        'slug',
        'abbreviation',
        'description',
        'disabled',
    ];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the admin who owns the admin group.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the admin team that owns the admin group.
     */
    public function team(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(AdminTeam::class, 'admin_team_id');
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

        foreach (AdminGroup::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
