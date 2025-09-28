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
     * Returns an array of options for an industry select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @param bool $includeOther
     * @param bool $useAbbreviation
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       bool $includeBlank = false,
                                       bool $nameAsKey = false,
                                       bool $includeOther = true,
                                       bool $useAbbreviation = false): array
    {
        $other = null;

        $options = [];
        if ($includeBlank) {
            $options[$nameAsKey ? '' : 0] = '';
        }

        $query = self::select('id', 'name')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $industry) {
            if ($industry->name == 'other') {
                $other = $industry;
            } else {
                $key = $nameAsKey
                    ? ($useAbbreviation ? $industry->abbreviation : $industry->name)
                    : $industry->id;
                $options[$key] = ($useAbbreviation ? $industry->abbreviation : $industry->name);
            }
        }

        // we put the 'other' option last
        if ($includeOther && !empty($other)) {
            $key = $nameAsKey
                ? ($useAbbreviation ? $industry->abbreviation : $industry->name)
                : $industry->id;
            $options[$key] = ($useAbbreviation ? $industry->abbreviation : $industry->name);;
        }

        return $options;
    }
}
