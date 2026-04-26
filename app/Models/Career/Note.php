<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\NoteFactory;
use Exception;
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
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email',
        'application_apply_date',
        'application_post_date',
        'application_role',
        'company_id',
        'company_name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'application_id', 'subject', 'body', 'notes', 'link', 'link_name',
        'description', 'disclaimer', 'is_public', 'is_readonly','is_root', 'is_disabled', 'is_demo', 'created_at',
        'updated_at'
    ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'created_at', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'application_id|asc'          => 'application',
        'body|as       c'             => 'body',
        'company_name|asc'            => 'company',
        'created_at|desc'             => 'created at',
        'application_apply_date|desc' => 'date applied',
        'application_close_date|desc' => 'date closed',
        'application_post_date|desc'  => 'date posted',
        'is_demo|desc'                => 'demo',
        'is_disabled|desc'            => 'disabled',
        'id|asc'                      => 'id',
        'owner_id|asc'                => 'owner id',
        'owner_name|asc'              => 'owner name',
        'owner_username|asc'          => 'owner username',
        'is_public|desc'              => 'public',
        'is_readonly|desc'            => 'read-only',
        'is_root|desc'                => 'root',
        'sequence|asc'                => 'sequence',
        'subject|asc'                 => 'subject',
        'updated_at|desc'             => 'updated at',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'application_id', 'body', 'created_at', 'subject', ],
        'guest' => [ 'application_id', 'body', 'created_at', 'subject', ]
    ];

    /**
     * This is the default sort order for searches.
     */
    public function __construct()
    {
        parent::__construct();
    }

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
     * @param string|null $sort - column for sort order, append "|asc" or "|desc" to specify direction
     * @param Admin|Owner|null $owner
     * @param User|null $user
     * @return Builder
     * @throws Exception
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->newQuery()
            ->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['application_apply_date']), function ($query) use ($filters) {
                $query->where('applications.apply_date', '=', intval($filters['application_apply_date']));
            })
            ->when(!empty($filters['application_apply_date_from']), function ($query) use ($filters) {
                $query->where('applications.apply_date', '>=', intval($filters['application_apply_date_from']));
            })
            ->when(!empty($filters['application_apply_date_to']), function ($query) use ($filters) {
                $query->where('applications.apply_date', '<=', intval($filters['application_apply_date_to']));
            })
            ->when(!empty($filters['application_id']), function ($query) use ($filters) {
                $query->where($this->table . '.application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['application_name']), function ($query) use ($filters) {
                $applicationName = $filters['application_name'];
                $query->where(function ($query) use ($applicationName) {
                    $query->where('companies.name', 'LIKE', '%' . $applicationName . '%')
                        ->orWhere('applications.role', 'LIKE', '%' . $applicationName . '%')
                        ->orWhere('applications.apply_date', 'LIKE', '%' . $applicationName . '%');
                });
            })
            ->when(!empty($filters['application_post_date_from']), function ($query) use ($filters) {
                $query->where('applications.post_date', '>=', intval($filters['application_post_date_from']));
            })
            ->when(!empty($filters['application_post_date_to']), function ($query) use ($filters) {
                $query->where('applications.post_date', '<=', intval($filters['application_post_date_to']));
            })
            ->when(!empty($filters['application_role']), function ($query) use ($filters) {
                $query->where('applications.application_role', '=', intval($filters['application_role']));
            })
            ->when(!empty($filters['body']), function ($query) use ($filters) {
                $query->where($this->table . '.body', 'like', '%' . $filters['body'] . '%');
            })
            ->when(!empty($filters['company_id']), function ($query) use ($filters) {
                $query->where('applications.company_id', '=', intval($filters['company_id']));
            })
            ->when(!empty($filters['company_name']), function ($query) use ($filters) {
                $query->where('companies.name', 'like', '%' . $filters['company_name'] . '%');
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

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add joins
        $query->join(dbName('system_db') . '.admins', 'admins.id', '=', $this->table . '.owner_id')
            ->join('applications', 'applications.id', '=', $this->table . '.application_id')
            ->join('companies', 'companies.id', '=', 'applications.company_id');

        $query->select([
            DB::raw($this->table . '.*'),
            DB::raw('applications.apply_date as application_apply_date'),
            DB::raw('applications.post_date as application_post_date'),
            DB::raw('applications.role as application_role'),
            DB::raw('applications.company_id as company_id'),
            DB::raw('companies.name as company_name'),
            DB::raw('admins.name AS `owner_name`'),
            DB::raw('admins.username AS `owner_username`'),
            DB::raw('admins.email AS `owner_email`'),
        ]);

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system owner of the note.
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
