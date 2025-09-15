<?php

namespace App\Models\Career;

use App\Models\Career\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JobTask extends Model
{
    use Notifiable, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'job_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_id',
        'job_title',
        'summary',
        'link',
        'link_name',
        'description',
        'notes',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
        'admin_id',
    ];

    /**
     * Get the job that owns the coworker.
     */
    public function job(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Job::class, 'job_id');
    }
}
