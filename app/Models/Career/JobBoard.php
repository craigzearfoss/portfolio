<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobBoard extends Model
{
    use SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'job_boards';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
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
    ];

    /**
     * Get the career applications for the career job board.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeOther
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeOther = false, bool $nameAsKey = true): array
    {
        $options = [];

        $other = null;

        foreach (JobBoard::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            if ($row->name == 'other') {
                $other = $row;
            } else {
                $options[$nameAsKey ? $row->name : $row->id] = $row->name;
            }
        }

        if ($includeOther && !empty($other)) {
            $options[$nameAsKey ? $other->name : $other->id] = $other->name;
        }

        return $options;
    }
}
