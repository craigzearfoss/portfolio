<?php

namespace App\Models\Portfolio;

use App\Models\Portfolio\School;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Education extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'education';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'degree_type_id',
        'major',
        'minor',
        'school_id',
        'slug',
        'enrollment_month',
        'enrollment_year',
        'graduated',
        'graduation_month',
        'graduation_year',
        'currently_enrolled',
        'summary',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'degree_type_id', 'major', 'minor', 'school_id', 'currently_enrolled',
        'completed', 'start_month', 'start_year', 'end_month', 'end_year', 'public', 'readonly', 'root', 'disabled',
        'demo'];
    const SEARCH_ORDER_BY = ['major', 'asc'];

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

        $query = self::getSearchQuery($filters)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['degree_type_id']), function ($query) use ($filters) {
                $query->where('degree_type_id', '=', intval($filters['degree_type_id']));
            })
            ->when(!empty($filters['major']), function ($query) use ($filters) {
                $query->where('major', 'like', '%' . $filters['major'] . '%');
            })
            ->when(!empty($filters['minor']), function ($query) use ($filters) {
                $query->where('minor', 'like', '%' . $filters['minor'] . '%');
            })
            ->when(isset($filters['school_id']), function ($query) use ($filters) {
                $query->where('school_id', '=', intval($filters['school_id']));
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(isset($filters['enrollment_month']), function ($query) use ($filters) {
                $query->where('enrollment_month', '=', intval($filters['enrollment_month']));
            })
            ->when(isset($filters['enrollment_year']), function ($query) use ($filters) {
                $query->where('enrollment_year', '=', intval($filters['enrollment_year']));
            })
            ->when(isset($filters['graduated']), function ($query) use ($filters) {
                $query->where('graduated', '=', intval($filters['graduated']));
            })
            ->when(isset($filters['graduation_month']), function ($query) use ($filters) {
                $query->where('graduation_month', '=', intval($filters['graduation_month']));
            })
            ->when(isset($filters['graduation_year']), function ($query) use ($filters) {
                $query->where('graduation_year', '=', intval($filters['graduation_year']));
            })
            ->when(isset($filters['currently_enrolled']), function ($query) use ($filters) {
                $query->where('currently_enrolled', '=', intval($filters['currently_enrolled']));
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });

        return $query;
    }

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Get the portfolio degree type that owne the education.
     */
    public function degreeType(): BelongsTo
    {
        return $this->belongsTo(DegreeType::class, 'degree_type_id');
    }

    /**
     * Get the system owner of the education.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio school that owns the education.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
