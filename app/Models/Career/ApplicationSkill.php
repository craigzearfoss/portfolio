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
 *
 */
class ApplicationSkill extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'application_skills';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'name',
        'level',
        'dictionary_category_id',
        'dictionary_term_id',
        'start_year',
        'end_year',
        'years',
        'notes',
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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'owner_id', 'application_id', 'name', 'level', 'dictionary_category_id',
        'dictionary_term_id', 'start_year', 'end_year', 'years', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

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
                $query->where($this->table . '.application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where($this->table . '.dictionary_category_id', '=', intval($filters['dictionary_category_id']));
            })
            ->when(!empty($filters['dictionary_term_id']), function ($query) use ($filters) {
                $query->where($this->table . '.dictionary_term_id', '=', intval($filters['dictionary_term_id']));
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['end_year']), function ($query) use ($filters) {
                $query->where($this->table . '.end_year', '=', intval($filters['end_year']));
            })
            ->when(!empty($filters['level']), function ($query) use ($filters) {
                $query->where($this->table . '.level', '=', intval($filters['level']));
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['start_year']), function ($query) use ($filters) {
                $query->where($this->table . '.start_year', '=', intval($filters['start_year']));
            })
            ->when(!empty($filters['years']), function ($query) use ($filters) {
                $query->where($this->table . '.years', '=', intval($filters['years']));
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Get the system owner of the application skill.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application of the application skill.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
