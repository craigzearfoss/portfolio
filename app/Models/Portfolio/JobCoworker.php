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
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Eloquent
 * @mixin Builder
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
        'level_id',
        'work_phone',
        'personal_phone',
        'work_email',
        'personal_email',
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

    const array LEVELS = [
        1 => 'coworker',
        2 => 'superior',
        3 => 'subordinate',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'job_id', 'name', 'title', 'level_id', 'work_phone', 'personal_phone',
        'work_email', 'personal_email', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * @return void
     */
    protected static function booted()
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

        return self::getSearchQuery($filters, $owner)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['job_id']), function ($query) use ($filters) {
                $query->where('job_id', '=', intval($filters['job_id']));
            })
            ->when(!empty($filters['title']), function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['title'] . '%');
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval($filters['featured']));
            })
            ->when(isset($filters['level_id']), function ($query) use ($filters) {
                $query->where('level_id', '=', intval($filters['level_id']));
            })
            ->when(!empty($filters['work_phone']), function ($query) use ($filters) {
                $query->where('work_phone', 'like', '%' . $filters['work_phone'] . '%');
            })
            ->when(!empty($filters['personal_phone']), function ($query) use ($filters) {
                $query->where('personal_phone', 'like', '%' . $filters['personal_phone'] . '%');
            })
            ->when(!empty($filters['work_email']), function ($query) use ($filters) {
                $query->where('work_email', 'like', '%' . $filters['work_email'] . '%');
            })
            ->when(!empty($filters['personal_email']), function ($query) use ($filters) {
                $query->where('personal_email', 'like', '%' . $filters['personal_email'] . '%');
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
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
}
