<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reference extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ReferenceFactory> */
    use SearchableModelTrait, HasFactory;

    protected $connection = 'career_db';

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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'friend', 'family', 'coworker', 'supervisor', 'subordinate',
        'professional', 'other', 'company_id', 'street', 'street2', 'city', 'state_id', 'zip', 'country_id', 'phone',
        'alt_phone', 'email', 'alt_email', 'birthday', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
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
     * Get the system state that owns the reference.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
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
}
