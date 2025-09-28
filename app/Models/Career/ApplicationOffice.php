<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationOffice extends Model
{
    protected $connection = 'career_db';

    protected $table = 'application_offices';

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
     * Get the career applications for the career application office.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'application_office_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Returns an array of options for an application office select list.
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

        foreach ($query->get() as $office) {
            $options[$nameAsKey ? $office->name : $office->id] = $office->name;
        }

        return $options;
    }
}
