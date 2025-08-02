<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
     * Returns an array of options for a select list for office types.
     *
     * @param bool $includeBlank
     * @param bool $codesAsKey
     * @return array|string[]
     */
    public static function officeListOptions(bool $includeBlank = false, bool $codesAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $codesAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::OFFICES as $i=>$office) {
            $options[$codesAsKey ? $office : $i] = $office;
        }

        return $options;
    }

    /**
     * Returns the office name for the giving index or null if not found.
     *
     * @param integer $index
     * @return string|null
     */
    public static function officeName($index): string | null
    {
        return self::OFFICES[$index] ?? null;
    }

    /**
     * Returns the office index for the giving name or null if not found.
     *
     * @param string $name
     * @return int|null
     */
    public static function officeIndex($name): integer | null
    {
        $key = array_search($name, self::OFFICES);

        return self::OFFICES[$key] ?? null;
    }

    /**
     * Returns an array of options for a select list for compensation units.
     *
     * @param bool $includeBlank
     * @param bool $codesAsKey
     * @return array|string[]
     */
    public static function compensationUnitListOptions(bool $includeBlank = false, bool $codesAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $codesAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::COMPENSATION_UNITS as $i=>$compensationUnit) {
            $options[$codesAsKey ? $compensationUnit : $i] = $compensationUnit;
        }

        return $options;
    }

    /**
     * Returns an array of options for a select list for types of employment.
     *
     * @param bool $includeBlank
     * @param bool $codesAsKey
     * @return array|string[]
     */
    public static function typeListOptions(bool $includeBlank = false, bool $codesAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $codesAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::TYPES as $i=>$type) {
            $options[$codesAsKey ? $type : $i] = $type;
        }

        return $options;
    }

    /**
     * Returns the type name for the giving index or null if not found.
     *
     * @param integer $index
     * @return string|null
     */
    public static function typeName($index): string | null
    {
        return self::TYPES[$index] ?? null;
    }

    /**
     * Returns the type index for the giving name or null if not found.
     *
     * @param string $name
     * @return int|null
     */
    public static function typeIndex($name): integer | null
    {
        $key = array_search($name, self::TYPES);

        return self::TYPES[$key] ?? null;
    }
}
