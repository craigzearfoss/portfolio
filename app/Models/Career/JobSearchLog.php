<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class JobSearchLog extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'message',
        'application_id',
        'job_id',
        'cover_letter_id',
        'resume_id',
        'company_id',
        'contact_id',
        'communication_id',
        'event_id',
        'note_id',
        'reference_id',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'message', 'application_id', 'job_id', 'cover_letter_id',
        'resume_id', 'company_id', 'contact_id', 'communication_id', 'event_id', 'note_id', 'reference_id' ];

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
            ->when(!empty($filters['job_id']), function ($query) use ($filters) {
                $query->where('job_id', '=', intval($filters['job_id']));
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
            });
    }
}
