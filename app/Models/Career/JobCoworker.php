<?php

namespace App\Models\Career;

use App\Models\Career\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JobCoworker extends Model
{
    use Notifiable, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'job_coworkers';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_id',
        'name',
        'level',
        'job_title',
        'work_phone',
        'personal_phone',
        'work_email',
        'personal_email',
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

    const LEVELS = [
        1 => 'coworker',
        2 => 'superior',
        3 => 'subordinate',
    ];

    /**
     * Get the job that owns the coworker.
     */
    public function job(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Job::class, 'job_id');
    }

    /**
     * Returns an array of options for a select list for title.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function levelListOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::LEVELS as $i=>$level) {
            $options[$nameAsKey ? $level : $i] = $level;
        }

        return $options;
    }
}
