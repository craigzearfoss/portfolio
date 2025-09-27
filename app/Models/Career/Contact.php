<?php

namespace App\Models\Career;

use App\Models\Country;
use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ContactFactory> */
    use HasFactory, Notifiable, SoftDeletes;

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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the career contact.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the country that owns the career contact.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the state that owns the career contact.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }

    /**
     * Returns an array of options for a select list for title.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function titleListOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::TITLES as $i=>$title) {
            $options[$nameAsKey ? $title : $i] = $title;
        }

        return $options;
    }

    /**
     * Returns the title name for the given id or null if not found.
     *
     * @param int $id
     * @return string|null
     */
    public static function titleName(int $id): string | null
    {
        return self::TITLES[$id] ?? null;
    }

    /**
     * Returns the title id for the giving name or false if not found.
     *
     * @param string $name
     * @return int|bool
     */
    public static function titleIndex(string $name): string |bool
    {
        return array_search($name, self::TITLES);
    }
}
