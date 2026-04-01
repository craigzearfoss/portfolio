<?php

namespace App\Models\Portfolio;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\JobCoworkerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class JobCoworker extends Model
{
    /** @use HasFactory<JobCoworkerFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'job_coworkers';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'job_id',
        'name',
        'title',
        'featured',
        'summary',
        'level_id',
        'phone',
        'phone_label',
        'alt_phone',
        'alt_phone_label',
        'email',
        'email_label',
        'alt_email',
        'alt_email_label',
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
     *
     */
    const array LEVELS = [
        1 => 'coworker',
        2 => 'superior',
        3 => 'subordinate',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'job_id', 'name', 'title', 'featured', 'summary', 'level_id',
        'phone', 'phone_label', 'alt_phone', 'alt_phone_label', 'email', 'email_label', 'alt_email', 'alt_email_label',
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
     * Returns an array of options for a level select.
     *
     * @param array $filters (Not used but included to keep signature consistent with other listOptions methods.)
     * @param string $valueColumn
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther (Not used but included to keep signature consistent with other listOptions methods.)
     * @param array $orderBy (Not used but included to keep signature consistent with other listOptions methods.)
     * @param EnvTypes $envType (Not used but included to keep signature consistent with other listOptions methods.)
     * @return array
     */
    public static function levelListOptions(array  $filters = [],
                                            string $valueColumn = 'id',
                                            string $labelColumn = 'name',
                                            bool   $includeBlank = false,
                                            bool   $includeOther = false,
                                            array  $orderBy = ['name', 'asc'],
                                            EnvTypes $envType = EnvTypes::GUEST): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        foreach (self::LEVELS as $i => $level) {
            $options[$valueColumn == 'id' ? $i : $level] = $labelColumn == 'id' ? $i : $level;
        }

        return $options;
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
            ->when(!empty($filters['company']), function ($query) use ($filters) {
                $query->where('jobs.company', 'like', '%' . $filters['company'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where($this->table . '.featured', '=', true);
            })
            ->when(!empty($filters['job_id']), function ($query) use ($filters) {
                $query->where($this->table . '.job_id', '=', intval($filters['job_id']));
            })
            ->when(!empty($filters['level_id']), function ($query) use ($filters) {
                $query->where($this->table . '.level_id', '=', intval($filters['level_id']));
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->where('jobs.role', 'like', '%' . $filters['role'] . '%');
            })
            ->when(!empty($filters['summary']), function ($query) use ($filters) {
                $query->where($this->table . '.summary', 'like', '%' . $filters['summary'] . '%');
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where($this->table . '.title', 'like', '%' . $filters['title'] . '%');
            });

        $query = $this->appendPhoneFilters($query, $filters);
        $query = $this->appendEmailFilters($query, $filters);
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        $query->join('jobs', 'jobs.id', '=', $this->table . '.job_id');
        $query->select([
            DB::raw($this->table . '.*'),
            DB::raw('jobs.company as company'),
            DB::raw('jobs.role as role'),
        ]);

        return $query;
    }

    /**
     * Get the system owner of the job coworker.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career job of the job coworker.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * Get the level of the job.
     */
    protected function level(): Attribute
    {
        return new Attribute(
            get: fn () => self::LEVELS[$this->level_id] ?? ''
        );
    }
}
