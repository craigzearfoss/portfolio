<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\ReadingFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'readings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'author',
        'paper',
        'audio',
        'wishlist',
        'link',
        'link_name',
        'notes',
        'seq',
        'hidden',
        'disabled',
    ];

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public static function authorListOptions(bool $includeBlank = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::select('id', 'author')->distinct('author')->orderBy('author', 'asc')->get() as $row) {
            $options[$row->id] = $row->author;
        }

        return $options;
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public static function titleListOptions(bool $includeBlank = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::select('id', 'title')->orderBy('title', 'asc')->get() as $row) {
            $options[$row->id] = $row->title;
        }

        return $options;
    }
}
