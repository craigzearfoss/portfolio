<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\LinkFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'links';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'professional',
        'personal',
        'url',
        'website',
        'description',
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
    public static function listOptions(bool $includeBlank = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$row->id] = $row->name;
        }

        return $options;
    }
}
