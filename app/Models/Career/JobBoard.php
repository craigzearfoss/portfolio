<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobBoard extends Model
{
    use SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'job_boards';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'primary',
        'local',
        'regional',
        'national',
        'international',
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
     * Get the applications for the job board.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Get the coverage areas for the job board (international, national, regional, local).
     */
    protected function coverageAreas(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getCoverageAreas()
        );
    }

    /**
     * Return an array of coverage areas for the job board (international, national, regional, local).
     *
     * @return array
     */
    protected function getCoverageAreas(): array
    {
        $coverageAreas = [];
        if (!empty($this->international)) $coverageAreas[] = 'international';
        if (!empty($this->national)) $coverageAreas[] = 'national';
        if (!empty($this->regional)) $coverageAreas[] = 'regional';
        if (!empty($this->local)) $coverageAreas[] = 'local';

        return $coverageAreas;
    }

    /**
     * Returns an array of options for a job board select list.
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

        foreach ($query->get() as $jobBoard) {
            if ($jobBoard->name == 'other') {
                $other = $jobBoard;
            } else {
                $options[$nameAsKey ? $jobBoard->name : $jobBoard->id] = $jobBoard->name;
            }
        }

        // we put the 'other' option last
        if ($includeOther && !empty($other)) {
            $options[$nameAsKey ? $other->name : $other->id] = $other->name;
        }

        return $options;
    }
}
