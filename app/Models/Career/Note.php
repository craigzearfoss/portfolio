<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\NoteFactory;
use Eloquent;
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
class Note extends Model
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
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'subject',
        'body',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'application_id', 'subject', 'body', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'created_at', 'desc' ];

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

        if (!empty($owner)) {
            if (isset($filters['owner_id'])) {
                unset($filters['owner_id']);
            }
            $filters[] = ['owner_id' => $owner->id];
        }

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['application_id']), function ($query) use ($filters) {
                $query->where($this->table . '.application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['body']), function ($query) use ($filters) {
                $query->where($this->table . '.body', 'like', '%' . $filters['body'] . '%');
            })
            ->when(!empty($filters['company_id']), function ($query) use ($filters) {
                $query->where('company_id', '=', intval($filters['company_id']));
            })
            ->when(!empty($filters['company_name']), function ($query) use ($filters) {
                $query->where('companies.name', '=', 'like', '%' . $filters['company_name'] . '%');
            })
            ->when(!empty($filters['created_at_from']), function ($query) use ($filters) {
                $query->where($this->table . '.date', '>=', $filters['created_at_from']);
            })
            ->when(!empty($filters['created_at_to']), function ($query) use ($filters) {
                $query->where($this->table . '.created_at', '<=', $filters['created_at_to']);
            })
            ->when(!empty($filters['subject']), function ($query) use ($filters) {
                $query->where($this->table . '.subject', 'like', '%' . $filters['subject'] . '%');
            });

        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        $query->join('applications', 'applications.id', '=', $this->table . '.application_id');
        $query->join('companies', 'companies.id', '=', 'applications.company_id');
        $query->select([
            DB::raw($this->table . '.*'),
            DB::raw('applications.company_id as company_id'),
            DB::raw('companies.name as company_name'),
        ]);

        return $query;
    }

    /**
     * Get the system owner who owns the note.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application that owns the note.
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
