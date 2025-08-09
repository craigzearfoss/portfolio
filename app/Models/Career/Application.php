<?php

namespace App\Models\Career;

use App\Models\Admin;
use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\Resume;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'admin_id',
        'company_id',
        'cover_letter_id',
        'resume_id',
        'role',
        'rating',
        'active',
        'resume_id',
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
     * Get the admin who owns the application.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }


    /**
     * Get the company who owns the application.
     */
    public function company(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Company::class, 'company_id');
    }

    /**
     * Get the cover letter who owns the application.
     */
    public function coverLetter(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(CoverLetter::class, 'cover_letter_id');
    }

    /**
     * Get the cover letter who owns the application.
     */
    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class, 'resume_id');
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
