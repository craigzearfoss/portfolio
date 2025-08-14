<?php

namespace App\Models\Career;

use App\Models\Career\TechnologyCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Technology extends Model
{
    protected $connection = 'career_db';

    protected $table = 'technologies';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'technology_category_id',
        'description'
    ];


    /**
     * Get the job_skill_category that owns the job_skill.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(TechnologyCategory::class, 'technology_category_id');
    }
}
