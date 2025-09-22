<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationSchedule extends Model
{
    protected $connection = 'career_db';

    protected $table = 'application_schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    /**
     * Get the career applications for the career schedule.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'application_schedule_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Returns an array of options for a select list for application schedule.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (ApplicationSchedule::all() as $schedule) {
            $options[$nameAsKey ? $schedule->name : $schedule->id] = $schedule->name;
        }

        return $options;
    }
}
