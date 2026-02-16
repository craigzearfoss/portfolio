<?php

namespace App\Models\Career;

use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\RecruiterFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Recruiter extends Model
{
    /** @use HasFactory<RecruiterFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'recruiters';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'postings_url',
        'local',
        'regional',
        'national',
        'international',
        'local',
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
        'link',
        'link_name',
        'description',
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
    const array SEARCH_COLUMNS = ['id', 'name', 'local', 'regional', 'national', 'international', 'street', 'street2',
        'city', 'state_id', 'zip', 'country_id', 'phone', 'alt_phone', 'email', 'alt_email', 'public', 'readonly',
        'root', 'disabled'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

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
        return self::getSearchQuery($filters, $owner)
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(isset($filters['local']), function ($query) use ($filters) {
                $query->where('local', '=', boolval($filters['local']));
            })
            ->when(isset($filters['regional']), function ($query) use ($filters) {
                $query->where('regional', '=', boolval($filters['regional']));
            })
            ->when(isset($filters['national']), function ($query) use ($filters) {
                $query->where('national', '=', boolval($filters['national']));
            })
            ->when(isset($filters['international']), function ($query) use ($filters) {
                $query->where('international', '=', boolval($filters['international']));
            })
            ->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where('city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where('state_id', '=', intval($filters['state_id']));
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where('country_id', '=', intval($filters['country_id']));
            })
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $email = $filters['email'];
                $query->orWhere(function ($query) use ($email) {
                    $query->where('email', 'LIKE', '%' . $email . '%')
                        ->orWhere('alt_email', 'LIKE', '%' . $email . '%');
                });
            })
            ->when(!empty($filters['phone']), function ($query) use ($filters) {
                $phone = $filters['phone'];
                $query->orWhere(function ($query) use ($phone) {
                    $query->where('phone', 'LIKE', '%' . $phone . '%')
                        ->orWhere('alt_phone', 'LIKE', '%' . $phone . '%');
                });
            })
            ->when(!empty($filters['body']), function ($query) use ($filters) {
                $query->where('body', 'like', '%' . $filters['body'] . '%');
            });
    }

    /**
     * Get the system country that owns the recruiter.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the system state that owns the recruiter.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the coverage areas for the recruiter (international, national, regional, local).
     */
    protected function coverageAreas(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getCoverageAreas()
        );
    }

    /**
     * Return an array of coverage areas for the recruiter (international, national, regional, local).
     */
    protected function getCoverageAreas()
    {
        $coverageAreas = [];
        if (!empty($this->international)) $coverageAreas[] = 'international';
        if (!empty($this->national)) $coverageAreas[] = 'national';
        if (!empty($this->regional)) $coverageAreas[] = 'regional';
        if (!empty($this->local)) $coverageAreas[] = 'local';

        return $coverageAreas;
    }
}
