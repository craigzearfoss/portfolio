<?php

namespace App\Models\Career;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Traits\SearchableModelTrait;
use Database\Factories\Career\ResumeFactory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'resume_date',
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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email',
        'name',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'name', 'file_type', 'resume_date', 'primary', 'doc_filepath',
        'pdf_filepath', 'content', 'file_type', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly',
        'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'resume_date', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        //'application_id|asc' => 'application id',
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'resume_date|desc'   => 'date',
        'is_demo|desc'       => 'demo',
        'is_disabled|desc'   => 'disabled',
        'id|asc'             => 'id',
        'name|asc'           => 'name',
        'owner_id|asc'       => 'owner id',
        'owner_name|asc'     => 'owner name',
        'owner_username|asc' => 'owner username',
        'primary|desc'       => 'primary',
        'is_public|desc'     => 'public',
        'is_readonly|desc'   => 'read-only',
        'is_root|desc'       => 'root',
        'sequence|asc'       => 'sequence',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ /*'is_disabled',*/ 'resume_date', 'name', 'is_public', ],
        'guest' => [ 'resume_date', 'name', 'is_public', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

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
                                array               $orderBy = ['resume_date', 'desc'],
                                EnvTypes $envType = EnvTypes::GUEST): array
    {
        $other = null;

        $options = $includeBlank ? [ '' => '' ] : [];

        // set the columns
        $selectColumns = [
            $this->table . '.id',
            'CONCAT(resume_date, " - ", ' . $this->table . '.name) AS name',
            $this->table . '.primary',
            $this->table . '.is_disabled',
        ];

        foreach ([$valueColumn, $labelColumn] as $field) {
            if (!empty($field) && ($field !== 'name')) {
                if ($field = $this->fullyQualifiedField($field)) {
                    if (!in_array($field, $selectColumns)) {
                        $selectColumns[] = $field;
                    }
                }
            }
        }

        // set the order by
        $sortColumn = $orderBy[0] ?? $this->table . '.' . self::SEARCH_ORDER_BY[0];
        if (!in_array($sortColumn, $selectColumns) && !in_array($sortColumn, self::PREDEFINED_SEARCH_COLUMNS)) {
            $selectColumns[] = $sortColumn;
        }
        $sortDir = $orderBy[1] ?? self::SEARCH_ORDER_BY[1];

        // create the query
        $query = new self()->selectRaw(implode(',', $selectColumns))
            ->orderBy($sortColumn, $sortDir)
            ->orderBy($this->table . '.name');

        // apply filters to the query
        foreach ($filters as $col => $value) {

            // if the filter is owner_id and the value is null then ignore it because owner_id should always have a value
            if (($col == 'owner_id') && empty($value)) {
                continue;
            }

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
                $options[$row->{$valueColumn}] = $row->{$labelColumn} . ($row->primary ? '*' : '');
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
     * @param string|null $sort - column for sort order, append "|asc" or "|desc" to specify direction
     * @param Admin|Owner|null $owner
     * @param User|null $user
     * @return Builder
     * @throws Exception
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['content']), function ($query) use ($filters) {
                $query->where($this->table . '.content', 'like', '%' . $filters['content'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where($this->table . '.description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where($this->table . '.disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['doc_filepath']), function ($query) use ($filters) {
                $query->where($this->table . '.doc_filepath', 'like', '%' . $filters['doc_filepath'] . '%');
            })
            ->when(!empty($filters['file_type']), function ($query) use ($filters) {
                $query->where($this->table . '.file_type', '=', $filters['file_type']);
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where($this->table . '.notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['pdf_filepath']), function ($query) use ($filters) {
                $query->where($this->table . '.pdf_filepath', 'like', '%' . $filters['pdf_filepath'] . '%');
            })
            ->when(!empty($filters['primary']), function ($query) use ($filters) {
                $query->where($this->table . '.primary', '=', true);
            })
            ->when(!empty($filters['resume_date']), function ($query) use ($filters) {
                $query->where($this->table . '.resume_date', '=', $filters['resume_date']);
            })
            ->when(!empty($filters['resume_date_from']), function ($query) use ($filters) {
                $query->where($this->table . '.resume_date', '>=', $filters['resume_date_from']);
            })
            ->when(!empty($filters['resume_date_to']), function ($query) use ($filters) {
                $query->where($this->table . '.resume_date', '<=', $filters['resume_date_to']);
            });

        // add additional filters
        $query = $this->appendStandardFilters($query, $filters);
        $query = $this->appendTimestampFilters($query, $filters);

        // add order by clause
        $query = $this->addOrderBy($query, $sort);

        return $query;
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
    public static function fileTypes(bool $includeBlank = false): array
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
