<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ContactFactory> */
    use SearchableModelTrait, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'contacts';

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
        'job_title',
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

    const TITLES = [
        'Miss',
        'Mr.',
        'Mrs.',
        'Ms',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'city', 'state_id', 'zip', 'country_id',
        'phone', 'alt_phone', 'email', 'alt_email', 'birthday', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the contact.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the companies for the contact.
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->withPivot('active')->orderBy('name', 'asc');
    }

    /**
     * Get the country that owns the contact.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the state that owns the contact.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(State::class, 'state_id');
    }
}
