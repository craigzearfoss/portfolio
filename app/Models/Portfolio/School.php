<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Portfolio\Education;
use App\Models\System\Country;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'schools';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'enrollment',
        'founded',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'notes',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
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
    const SEARCH_COLUMNS = ['id', 'name', 'slug', 'enrollment', 'founded', 'street', 'street2', 'city', 'state_id',
        'zip', 'country_id'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the country that owns the school.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the educations for the school.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'education_id');
    }

    /**
     * Get the students for the school.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    /**
     * Get the state that owns the school.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }
}
