<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\CompanyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'industry_id',
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
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'industry_id', 'street', 'street2', 'city', 'state_id',
        'zip', 'country_id', 'phone', 'phone_label', 'alt_phone', 'alt_phone_label', 'email', 'email_label',
        'alt_email', 'alt_email_label', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root',
        'is_disabled', 'is_demo' ];

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
            ->when(!empty($filters['industry_id']), function ($query) use ($filters) {
                $query->where('industry_id', '=', intval($filters['industry_id']));
            });

        $query =$this->appendAddressFilters($query, $filters);
        $query =$this->appendPhoneFilters($query, $filters);
        $query =$this->appendEmailFilters($query, $filters);

            $query->when(!empty($filters['notes']), function ($query) use ($filters) {
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
     * Get the system owner of the company.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career applications for the company.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'company_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Get the contacts for the company.
     */
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class)->withPivot('active')
            ->orderBy('name');
    }

    /**
     * Get the system country that owns the company.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the career industry that owns the company.
     */
    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class, 'industry_id')
            ->orderBy('name');
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
     * Get the system state that owns the company.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }
}
