<?php

namespace App\Models\Personal;

use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    use SoftDeletes;

    protected $connection = 'personal_db';

    protected $table = 'readings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'author',
        'slug',
        'featured',
        'publication_year',
        'fiction',
        'nonfiction',
        'paper',
        'audio',
        'wishlist',
        'link',
        'link_name',
        'notes',
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
     * Get the owner of the reading.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Returns an array of options for a reading author select list.
     * Note that there might will be duplicate authors.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $authorAsKey - If true then duplicate authors are removed.
     * @return array|string[]
     */
    public static function authorListOptions(array  $filters = [],
                                             bool $includeBlank = false,
                                             bool $authorAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[$authorAsKey ? '' : 0] = '';
        }

        $query = self::select('id', 'author')->orderBy('author', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        if ($authorAsKey) {
            $query->distinct('author');
        }

        foreach ($query->get() as $reading) {
            $options[$authorAsKey ? $reading->author : $reading->id] = $reading->author;
        }

        return $options;
    }

    /**
     * Returns an array of title options for a reading title select list.
     * Note that there might will be duplicate titles.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $titleAsKey  - - If true then duplicate title are removed.
     * @return array|string[]
     */
    public static function titleListOptions(array  $filters = [],
                                            bool $includeBlank = false,
                                            bool $titleAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[$titleAsKey ? '' : 0] = '';
        }

        $query = self::select('id', 'title')->orderBy('title', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        if ($titleAsKey) {
            $query->distinct('title');
        }

        foreach ($query->get() as $reading) {
            $options[$titleAsKey ? $reading->title : $reading->id] = $reading->title;
        }

        return $options;
    }
}
