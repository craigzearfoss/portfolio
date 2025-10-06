<?php

namespace App\Models\Portfolio;

use App\Models\Owner;
use App\Models\Portfolio\Job;
use App\Models\Scopes\AdminGlobalScope;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JobCoworker extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\JobCoworkerFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'portfolio_db';

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
        'job_title',
        'level_id',
        'work_phone',
        'personal_phone',
        'work_email',
        'personal_email',
        'notes',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    const LEVELS = [
        1 => 'coworker',
        2 => 'superior',
        3 => 'subordinate',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'job_id', 'name', 'job_title', 'level_id', 'work_phone', 'personal_phone',
        'work_email', 'personal_email', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the job coworker.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the job of the job coworker.
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
     * @return array|string[]
     */
    public static function levelListOptions(array  $filters = [],
                                            string $valueColumn = 'id',
                                            string $labelColumn = 'name',
                                            bool   $includeBlank = false,
                                            bool   $includeOther = false,
                                            array  $orderBy = ['name', 'asc']): array
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
