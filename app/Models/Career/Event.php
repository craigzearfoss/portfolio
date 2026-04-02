<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\NoteFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class Event extends Model
{
    /** @use HasFactory<NoteFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'name',
        'datetime',
        'location',
        'attendees',
        'description',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'application_id', 'name', 'datetime', 'location', 'attendees',
        'description', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'datetime', 'desc' ];

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
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['application_id']), function ($query) use ($filters) {
                $query->where($this->table . '.application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['attendees']), function ($query) use ($filters) {
                $query->where($this->table . '.attendees', 'like', '%' . $filters['attendees'] . '%');
            })
            ->when(!empty($filters['company_id']), function ($query) use ($filters) {
                $query->where('company_id', '=', intval($filters['company_id']));
            })
            ->when(!empty($filters['company_name']), function ($query) use ($filters) {
                $query->where('companies.name', '=', 'like', '%' . $filters['company_name'] . '%');
            })
            ->when(!empty($filters['datetime_from']), function ($query) use ($filters) {
                $query->where($this->table . '.datetime', '>=', $filters['datetime_from']);
            })
            ->when(!empty($filters['datetime_to']), function ($query) use ($filters) {
                $query->where($this->table . '.datetime', '<=', $filters['datetime_to']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['location']), function ($query) use ($filters) {
                $query->where($this->table . '.location', 'like', '%' . $filters['location'] . '%');
            });

        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        $query->join('applications', 'applications.id', '=', $this->table . '.application_id');
        $query->join('companies', 'companies.id', '=', 'applications.company_id');
        $query->select([
            DB::raw('cover_letters.*'),
            DB::raw('applications.company_id as company_id'),
            DB::raw('companies.name as company_name'),
        ]);

        return $query;
    }

    /**
     * Get the system owner of the event.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application that owns event.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Get the career job search log entries for the cover letter.
     */
    public function jobSearchLogEntries(): HasMany
    {
        return $this->hasMany(JobSearchLog::class, 'application_id')
            ->orderBy('time_logged', 'desc');
    }
}
