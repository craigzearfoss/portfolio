<?php

namespace App\Models\Career;

use App\Models\Career\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    protected $connection = 'career_db';

    protected $table = 'industries';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'abbreviation',
    ];

    /**
     * Get the career companies for the career industry.
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $useAbbreviation
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false,bool $useAbbreviation = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ 0 => '' ];
        }

        $labelField = $useAbbreviation ? 'abbreviation' : 'name';

        foreach (Industry::select('id', $labelField)->orderBy($labelField, 'asc')->get() as $row) {
            $options[$row->id] = $row->{$labelField};
        }

        return $options;
    }
}
