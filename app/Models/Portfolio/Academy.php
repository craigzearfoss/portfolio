<?php

namespace App\Models\Portfolio;

use App\Models\Portfolio\Certification;
use App\Models\Portfolio\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Academy extends Model
{
    protected $connection = 'portfolio_db';

    protected $table = 'academies';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Get the portfolio certifications for the portfolio academy.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the portfolio courses for the portfolio academy.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Returns an array of options for an academy select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @param bool $includeOther
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       bool $includeBlank = false,
                                       bool $nameAsKey = false,
                                       bool $includeOther = true): array
    {
        $other = null;

        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $query = self::select('id', 'name')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $academy) {
            if ($academy->name == 'other') {
                $other = $academy;
            } else {
                $options[$nameAsKey ? $academy->name : $academy->id] = $academy->name;
            }
        }

        // we put the 'other' option last
        if ($includeOther && !empty($other)) {
            $options[$nameAsKey ? $academy->name : $academy->id] = $academy->name;;
        }

        return $options;
    }
}
