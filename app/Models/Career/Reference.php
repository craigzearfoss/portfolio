<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\ReferenceFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Reference extends Model
{
    /** @use HasFactory<ReferenceFactory> */
    use SearchableModelTrait, HasFactory;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'references';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'title',
        'friend',
        'family',
        'coworker',
        'supervisor',
        'subordinate',
        'professional',
        'other',
        'company_id',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'phone',
        'phone_label',
        'alt_phone',
        'alt_phone_label',
        'email',
        'email_label',
        'alt_email',
        'alt_email_label',
        'birthday',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'title', 'friend', 'family', 'coworker', 'supervisor',
        'subordinate', 'professional', 'other', 'company_id', 'street', 'street2', 'city', 'state_id', 'zip',
        'country_id', 'phone', 'phone_label', 'alt_phone', 'alt_phone_label', 'email', 'email_label', 'alt_email',
        'alt_email_label', 'birthday', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [];
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

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['coworker']), function ($query) use ($filters) {
                $query->where($this->table . '.coworker', '=', true);
            })
            ->when(!empty($filters['family']), function ($query) use ($filters) {
                $query->where($this->table . '.family', '=', true);
            })
            ->when(!empty($filters['friend']), function ($query) use ($filters) {
                $query->where($this->table . '.friend', '=', true);
            })
            ->when(!empty($filters['other']), function ($query) use ($filters) {
                $query->where($this->table . '.other', '=', true);
            })
            ->when(!empty($filters['professional']), function ($query) use ($filters) {
                $query->where($this->table . '.professional', '=', true);
            })
            ->when(!empty($filters['relation']), function ($query) use ($filters) {
                if (in_array($filters['relation'], ['coworker', 'family', 'friend', 'professional', 'subordinate', 'supervisor', 'other'])) {
                    $query->where($this->table . '.' . $filters['relation'], '=', true);
                } else {
                    throw new Exception('Invalid relation "' . $filters['relation'] . '" specified.'
                        . ' Valid relations are "coworker", "family", "friend", "professional", "subordinate", "supervisor", and "other".');
                }
            })
            ->when(!empty($filters['subordinate']), function ($query) use ($filters) {
                $query->where($this->table . '.subordinate', '=', true);
            })
            ->when(!empty($filters['supervisor']), function ($query) use ($filters) {
                $query->where($this->table . '.supervisor', '=', true);
            });

            $query =$this->appendAddressFilters($query, $filters);
            $query =$this->appendPhoneFilters($query, $filters);
            $query =$this->appendEmailFilters($query, $filters);

            $query->when(!empty($filters['birthday']), function ($query) use ($filters) {
                $query->where('birthday', '=', $filters['birthday']);
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

        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        $query = $this->addOrderBy($query, $sort);
        if (explode('|', $sort ?? '') != 'owner_username') {
            $query->orderBy('owner_username');
        }

        return $query;
    }

    /**
     * Get the system owner of the reference.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career company that owns the reference.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
    * Get the system country that owns the reference.
    */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Return the relation of the reference (family, friend, coworker, supervisor, subordinate, professional, other).
     *
     * @return string|null
     */
    protected function getReferenceRelation(): ?string
    {
        $relations = [];
        foreach (['family', 'friend', 'coworker', 'supervisor', 'subordinate', 'professional', 'other'] as $relation) {
            if (!empty($this->{$relation})) {
                $relations[] = $relation;
            }
        }

        return !empty($relations) ? implode(', ', $relations) : null;
    }

    /**
     * Get the career job search log entries for the cover letter.
     */
    public function jobSearchLogEntries(): HasMany
    {
        return $this->hasMany(JobSearchLog::class, 'application_id')
            ->orderBy('time_logged', 'desc');
    }

    /**
     * Get the relation of the reference (family, friend, coworker, supervisor, subordinate, professional, other).
     */
    protected function relation(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getReferenceRelation()
        );
    }

    /**
     * Get the system state that owns the reference.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }

}
