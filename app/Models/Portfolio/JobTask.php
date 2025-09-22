<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JobTask extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\JobTaskFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'portfolio_db';

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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the career job that owns the career coworker.
     */
    public function job(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Job::class, 'job_id');
    }
}
