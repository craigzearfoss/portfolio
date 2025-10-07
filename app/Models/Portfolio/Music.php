<?php

namespace App\Models\Portfolio;

use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\MusicFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'music';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'parent_id',
        'name',
        'artist',
        'slug',
        'featured',
        'summary',
        'collection',
        'track',
        'label',
        'catalog_number',
        'year',
        'release_date',
        'embed',
        'audio_url',
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
        'admin_id',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'parent_id', 'name', 'artist', 'featured', 'collection', 'track', 'label',
        'catalog_number', 'year', 'release_date', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the music.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the music.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Music::class, 'parent_id');
    }

    /**
     * Get the children of the music.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Music::class, 'parent_id');
    }

    /**
     * Returns an array of options for a music select list.
     *
     * @param array $filters
     * @param string $valueColumn
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther
     * @param array $orderBy
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array
     * @throws \Exception
     */
    public static function listOptions(array  $filters = [],
                                       string $valueColumn = 'id',
                                       string $labelColumn = 'name',
                                       bool   $includeBlank = false,
                                       bool   $includeOther = false,
                                       array  $orderBy = self::SEARCH_ORDER_BY): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $selectColumns = self::SEARCH_COLUMNS;
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        $query = self::select($selectColumns)->orderBy($sortColumn, $sortDir);

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
                        throw new \Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($col, $value);
                }
            }
        }

        foreach ($query->get() as $row) {
            if ($labelColumn == 'name') {
                $label = $row->name . (!empty($row->artist) ? ' - ' . $row->artist : '');
            } else {
                $label = $row->{$labelColumn};
            }
            $options[$row->{$valueColumn}] = $label;
        }

        return $options;
    }
}
