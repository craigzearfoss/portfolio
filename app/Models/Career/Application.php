<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ApplicationFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'applications';

    const TYPES = [
        'permanent',
        'contract',
        'contract-to-hire',
        'project',
    ];

    const OFFICES = [
        'onsite',
        'remote',
        'hybrid',
    ];

    const COMPENSATION_UNITS = [
            'hour',
            'year',
            'month',
            'week',
            'day',
            'project',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'rating',
        'active',
        'post_date',
        'apply_date',
        'close_date',
        'compensation',
        'compensation_unit',
        'duration',
        'type',
        'office',
        'city',
        'state',
        'bonus',
        'w2',
        'relocation',
        'benefits',
        'vacation',
        'health',
        'source',
        'link',
        'contacts',
        'phones',
        'emails',
        'website',
        'description',
        'apply_date',
    ];

    /**
     * The application has one company.
     */
    public function application(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    /**
     * The application has many notes.
     */
    public function note(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Returns an array of options for a select list for office types.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function officeListOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::OFFICES as $i=>$office) {
            $options[$nameAsKey ? $office : $i] = $office;
        }

        return $options;
    }

    /**
     * Returns the office name for the given id or null if not found.
     *
     * @param int $id
     * @return string|null
     */
    public static function officeName(int $id): string | null
    {
        return self::OFFICES[$id] ?? null;
    }

    /**
     * Returns the office id for the given name or null if not found.
     *
     * @param string $name
     * @return int|bool
     */
    public static function officeIndex(string $name): string | bool
    {
        return array_search($name, self::OFFICES);
    }

    /**
     * Returns an array of options for a select list for compensation units.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function compensationUnitListOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::COMPENSATION_UNITS as $i=>$compensationUnit) {
            $options[$nameAsKey ? $compensationUnit : $i] = $compensationUnit;
        }

        return $options;
    }

    /**
     * Returns an array of options for a select list for types of employment.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function typeListOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::TYPES as $i=>$type) {
            $options[$nameAsKey ? $type : $i] = $type;
        }

        return $options;
    }

    /**
     * Returns the type name for the given id or null if not found.
     *
     * @param int $id
     * @return string|null
     */
    public static function typeName(int $id): string | null
    {
        return self::TYPES[$id] ?? null;
    }

    /**
     * Returns the type id for the given name or null if not found.
     *
     * @param string $name
     * @return string|bool
     */
    public static function typeIndex(string $name): string | bool
    {
        return array_search($name, self::TYPES);
    }
}
