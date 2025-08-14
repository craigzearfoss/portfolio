<?php

namespace App\Models\Career;

use App\Models\Career\JobSkill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobSkillCategory extends Model
{
    protected $connection = 'career_db';

    protected $table = 'job_skill_categories';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Get the job_skills for the job_skill_category.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(JobSkill::class);
    }

    /**
    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (JobBoard::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
