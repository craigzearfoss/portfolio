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
     * Returns an array of options for an application schedule select list.
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
            $options[''] = '';
        }

        $query = self::select('id', 'name')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $schedule) {
            $options[$nameAsKey ? $schedule->name : $schedule->id] = $schedule->name;
        }

        return $options;
    }
}
