<?php

namespace App\Models\Career;

use App\Models\Career\JobSkillCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSkill extends Model
{
    protected $connection = 'career_db';

    protected $table = 'job_skills';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'job_skill_category_id',
        'description'
    ];

    /**
     * Get the job_skill_category that owns the job_skill.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(JobSkillCategory::class, 'job_skill_category_id');
    }
}
