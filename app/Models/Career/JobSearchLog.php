<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class JobSearchLog extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'job_search_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'message',
        'time_logged',
        'application_id',
        'cover_letter_id',
        'resume_id',
        'company_id',
        'contact_id',
        'communication_id',
        'event_id',
        'note_id',
        'reference_id',
        'recruiter_id',
s    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'message', 'application_id', 'cover_letter_id', 'resume_id',
        'company_id', 'contact_id', 'communication_id', 'event_id', 'note_id', 'reference_id', 'recruiter_id' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['role', 'asc'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        return new self()->when(!empty($filters['id']), function ($query) use ($filters) {
            $query->where('id', '=', intval($filters['id']));
            })->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['application_id']), function ($query) use ($filters) {
                $query->where('application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['cover_letter_id']), function ($query) use ($filters) {
                $query->where('cover_letter_id', '=', intval($filters['cover_letter_id']));
            })
            ->when(!empty($filters['resume_id']), function ($query) use ($filters) {
                $query->where('resume_id', '=', intval($filters['resume_id']));
            })
            ->when(!empty($filters['company_id']), function ($query) use ($filters) {
                $query->where('company_id', '=', intval($filters['company_id']));
            })
            ->when(!empty($filters['contact_id']), function ($query) use ($filters) {
                $query->where('contact_id', '=', intval($filters['contact_id']));
            })
            ->when(!empty($filters['communication_id']), function ($query) use ($filters) {
                $query->where('communication_id', '=', intval($filters['communication_id']));
            })
            ->when(!empty($filters['event_id']), function ($query) use ($filters) {
                $query->where('event_id', '=', intval($filters['event_id']));
            })
            ->when(!empty($filters['note_id']), function ($query) use ($filters) {
                $query->where('note_id', '=', intval($filters['note_id']));
            })
            ->when(!empty($filters['reference_id']), function ($query) use ($filters) {
                $query->where('reference_id', '=', intval($filters['reference_id']));
            })
            ->when(!empty($filters['recruiter_id']), function ($query) use ($filters) {
                $query->where('recruiter_id', '=', intval($filters['recruiter_id']));
            });
    }


    /**
     * Get the career application that owns the job search log entry.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Get the career communication that owns the job search log entry.
     */
    public function communication(): BelongsTo
    {
        return $this->belongsTo(Communication::class, 'communication_id')->orderBy('name');
    }

    /**
     * Get the career company that owns the job search log entry.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')->orderBy('name');
    }

    /**
     * Get the career contact that owns the job search log entry.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id')->orderBy('name');
    }

    /**
     * Get the career cover letter that owns the job search log entry.
     */
    public function coverLetter(): BelongsTo
    {
        return $this->belongsTo(CoverLetter::class, 'cover_letter_id')->orderBy('name');
    }

    /**
     * Get the career event that owns the job search log entry.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id')->orderBy('name');
    }

    /**
     * Get the career note that owns the job search log entry.
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'note_id')->orderBy('name');
    }

    /**
     * Get the career recruiter that owns the job search log entry.
     */
    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id')->orderBy('name');
    }

    /**
     * Get the career resume that owns the job search log entry.
     */
    public function resume(): BelongsTo
    {
        return $this->belongsTo(Recruiter::class, 'resume_id')->orderBy('name');
    }
}
