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
use Illuminate\Support\Facades\DB;

/**
 *
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
        'doc_filepath',
        'pdf_filepath',
        'content',
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
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
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
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'file_type', 'date', 'primary', 'doc_filepath',
        'pdf_filepath', 'content', 'file_type', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'date', 'desc' ];

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
     * @param EnvTypes $envType
     * @return array
     * @throws Exception
     */
    public function listOptions(array               $filters = [],
                                string              $valueColumn = 'id',
                                string              $labelColumn = 'name',
                                bool                $includeBlank = false,
                                bool                $includeOther = false,
                                array               $orderBy = [],
                                EnvTypes $envType = EnvTypes::GUEST): array
    {
        $predefinedColumns = [ 'name' ];
        $other = null;

        $options = $includeBlank ? [ '' => '' ] : [];

        // set the columns
        $selectColumns = [
            $this->table . '.id',
            'CONCAT(date, " - ", ' . $this->table . '.name) AS name',
        ];

        foreach ([$valueColumn, $labelColumn] as $field) {
            if (!empty($field) && ($field !== 'name')) {
                if ($field = $this->fullyQualifiedField($field, $predefinedColumns)) {
                    if (!in_array($field, $selectColumns)) {
                        $selectColumns[] = $field;
                    }
                }
            }
        }

        // set the order by
        $sortColumn = $orderBy[0] ?? $this->table . '.' . self::SEARCH_ORDER_BY[0];
        if (!in_array($sortColumn, $selectColumns) && !in_array($sortColumn, $predefinedColumns)) {
            $selectColumns[] = $sortColumn;
        }
        $sortDir = $orderBy[1] ?? self::SEARCH_ORDER_BY[1];

        // create the query
        $query = new self()->selectRaw(implode(',', $selectColumns))
            ->orderBy($sortColumn, $sortDir);

        // apply filters to the query
        foreach ($filters as $col => $value) {

            // make sure common columns are fully qualified to avoid query errors
            if (in_array($col, self::COMMON_COLUMNS)) {
                $col = $this->table . '.' .$col;
            }

            // get the where clause
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
                    $query = $query->where($col, '=', $value);
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
        $filters = $this->removeEmptyFilters($filters);

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['content']), function ($query) use ($filters) {
                $query->where('content', 'like', '%' . $filters['content'] . '%');
            })
            ->when(!empty($filters['date']), function ($query) use ($filters) {
                $query->where('date', '=', $filters['date']);
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where('disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })            ->when(!empty($filters['doc_filepath']), function ($query) use ($filters) {
                $query->where('doc_filepath', 'like', '%' . $filters['doc_filepath'] . '%');
            })
            ->when(!empty($filters['file_type']), function ($query) use ($filters) {
                $query->where('file_type', '=', $filters['file_type']);
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['pdf_filepath']), function ($query) use ($filters) {
                $query->where('pdf_filepath', 'like', '%' . $filters['pdf_filepath'] . '%');
            })
            ->when(!empty($filters['primary']), function ($query) use ($filters) {
                $query->where('primary', '=', true);
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
