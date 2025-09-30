<?php

namespace App\Models\Career;

use App\Models\Country;
use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\State;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reference extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ReferenceFactory> */
    use HasFactory;

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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }
    /**
     * Get the owner of the career reference.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the company that owns the reference.
     */
    public function company(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Company::class, 'company_id');
    }

    /**
    * Get the country that owns the reference.
    */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the state that owns the reference.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(State::class, 'state_id');
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
