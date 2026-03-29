<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\CoverLetterFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class CoverLetter extends Model
{
    /** @use HasFactory<CoverLetterFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'cover_letters';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'name',
        'slug',
        'date',
        'filepath',
        'content',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'application_id', 'name', 'date', 'filepath', 'content', 'notes',
        'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

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
                $query->where('application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['content']), function ($query) use ($filters) {
                $query->where('content', 'like', '%' . $filters['content'] . '%');
            })
            ->when(!empty($filters['date']), function ($query) use ($filters) {
                $query->where('date', '=', $filters['date']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where('disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['filepath']), function ($query) use ($filters) {
                $query->where('filepath', 'like', '%' . $filters['filepath'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Get the system owner of the cover letter.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application that owns the career over letter.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Calculate the name of the application.
     *
     * @return string
     */
    protected function calculateName():string
    {
        $company = $this->application->company['name'];
        $role = $this->application['role'] ?? '?role?';
        $date = !empty($this->application['apply_date'])
            ? ' [applied: ' . $this->application['apply_date'] . ']'
            : (!empty($this->application['post_date']) ? ' [applied: ' . $this->application['apply_date'] . ']' : '');

        return $company . ' - ' . $role . $date;
    }

    /**
     * Get the name of the application.
     */
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->calculateName()
        );
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
