<?php

namespace App\Models\Career;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\ResumeFactory;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Resume extends Model
{
    /** @use HasFactory<ResumeFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'career_db';

    /**
     * @var string
     */
    protected $table = 'resumes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'date',
        'primary',
        'content',
        'doc_filepath',
        'pdf_filepath',
        'file_type',
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
     *
     */
    const array FILE_TYPES = [
        '.csv'   => 'CSV comma delimited (*.csv)',
        '.docx'  => 'Document (*.docx)',
        '.doc'   => 'Word 97-2003 (*.doc)',
        '.mht'   => 'Single File Web Page (*.mht, *.mhtml)',
        '.mhtml' => 'Single File Web Page (*.mht, *.mhtml)',
        '.dotx'  => 'Template (*.dotx)',
        '.ods'   => 'OpenDocument Spreadsheet (*.ods)',
        '.odt'   => 'OpenDocument Text (*.odt)',
        '.pdf'   => 'Adobe PDF (*.pdf)',
        '.rtf'   => 'Rich Text Format (*.rtf)',
        '.xls'   => 'Microsoft Excel 5.0/95 Workbook (*.xls)',
        '.xlsx'  => 'Excel (*.xlsx)',
        '.xml'   => 'XML Spreadsheet 2003 (*.xml)',
        'other'  => 'Other',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'file_type', 'date', 'primary', 'doc_filepath', 'pdf_filepath',
        'content', 'public', 'readonly', 'root', 'disabled', 'demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['date', 'desc'];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Returns an array of options for an industry select list.
     *
     * @param array    $filters
     * @param string   $valueColumn
     * @param string   $labelColumn
     * @param bool     $includeBlank
     * @param bool     $includeOther
     * @param array    $orderBy
     * @param EnvTypes $envType (Not used but included to keep signature consistent with other listOptions methods.)
     * @return array
     * @throws Exception
     */
    public function listOptions(array               $filters = [],
                                string              $valueColumn = 'id',
                                string              $labelColumn = 'name',
                                bool                $includeBlank = false,
                                bool                $includeOther = false,
                                array               $orderBy = self::SEARCH_ORDER_BY,
                                EnvTypes $envType = EnvTypes::GUEST): array
    {
        $other = null;

        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $selectColumns = self::SEARCH_COLUMNS ?? ['id', 'name'];
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        $query = new self()->selectRaw('CONCAT(date, " - ", name) AS name, id')
            ->orderBy($sortColumn, $sortDir);

        // Apply filters to the query.
        foreach ($filters as $col => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($col, $value);
            } else {
                $parts = explode(' ', $col);
                $col = $parts[0];
                if (!empty($parts[1])) {
                    $operation = trim($parts[1]);
                    if (in_array($operation, ['<>', '!=', '=!'])) {
                        $query->where($col, $operation, $value);
                    } elseif (strtolower($operation) == 'like') {
                        $query->whereLike($col, $value);
                    } else {
                        throw new Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($col, $value);
                }
            }
        }

        foreach ($query->get() as $row) {
            if ($row->{$labelColumn} == 'other') {
                $other = $row;
            } else {
                $options[$row->{$valueColumn}] = $row->{$labelColumn};
            }
        }

        // Put the 'other' option last.
        if ($includeOther) {
            if (!empty($other)) {
                $options[$other->{$valueColumn}] = $other->{$labelColumn};
            } else {
                $options[] = 'other';
            }
        }

        return $options;
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
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->getSearchQuery($filters)
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['date']), function ($query) use ($filters) {
                $query->where('date', '=', $filters['date']);
            })
            ->when(isset($filters['primary']), function ($query) use ($filters) {
                $query->where('primary', '=', boolval($filters['primary']));
            })
            ->when(!empty($filters['file_type']), function ($query) use ($filters) {
                $query->where('file_type', '=', $filters['file_type']);
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the system owner of the resume.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career applications for the resume.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'resume_id')->orderBy('post_date', 'desc');
    }

    /**
     * Returns an array of file types.
     *
     * @param $includeBlank bool
     * @return array
     */
    protected static function fileTypes(bool $includeBlank = false): array
    {
        return $includeBlank
            ? array_merge([ '' => ''], self::FILE_TYPES)
            : self::FILE_TYPES;
    }

    /**
     * Get the career job search log entries for the cover letter.
     */
    public function jobSearchLogEntries(): HasMany
    {
        return $this->hasMany(JobSearchLog::class, 'application_id')
            ->orderBy('time_logged', 'desc');
    }
}
