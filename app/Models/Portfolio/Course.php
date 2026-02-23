<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\CourseFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'featured',
        'summary',
        'year',
        'completed',
        'completion_date',
        'duration_hours',
        'academy_id',
        'school',
        'instructor',
        'sponsor',
        'certificate_url',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'featured', 'summary', 'year', 'completed',
        'completion_date', 'duration_hours', 'academy_id', 'school', 'instructor', 'sponsor', 'certificate_url',
        'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

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
        $query = new self()->getSearchQuery($filters, $owner)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where('summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(isset($filters['year']), function ($query) use ($filters) {
                $query->where('year', '=', $filters['year']);
            })
            ->when(!empty($filters['completed']), function ($query) use ($filters) {
                $query->where('completed', '=', boolval($filters['completed']));
            })
            ->when(!empty($filters['completion_date']), function ($query) use ($filters) {
                $query->where('completion_date', '=', $filters['completion_date']);
            })
            ->when(!empty($filters['duration_hours']), function ($query) use ($filters) {
                $query->where('duration_hours', '>=', floatval($filters['duration_hours']));
            })
            ->when(isset($filters['academy_id']), function ($query) use ($filters) {
                $query->where('academy_id', '=', intval(['academy_id']));
            })
            ->when(!empty($filters['school']), function ($query) use ($filters) {
                $query->where('school', 'like', '%' . $filters['school'] . '%');
            })
            ->when(!empty($filters['instructor']), function ($query) use ($filters) {
                $query->where('instructor', 'like', '%' . $filters['instructor'] . '%');
            })
            ->when(!empty($filters['sponsor']), function ($query) use ($filters) {
                $query->where('sponsor', 'like', '%' . $filters['sponsor'] . '%');
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where('disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system owner of the course.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio academy that owns the course.
     */
    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class, 'academy_id');
    }
}
