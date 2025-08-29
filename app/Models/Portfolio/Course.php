<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\CourseFactory> */
    use HasFactory;

    protected $connection = 'portfolio_db';

    protected $table = 'courses';

    const ACADEMIES = [
        'Amazon Web Services',
        'Gymnasium',
        'KodeKloud',
        'MongoDB University',
        'Scrimba',
        'SitePoint',
        'Udemy',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'name',
        'slug',
        'professional',
        'personal',
        'year',
        'completed',
        'academy',
        'website',
        'instructor',
        'sponsor',
        'link',
        'description',
        'image',
        'thumbnail',
        'sequence',
        'public',
        'disabled',
    ];

    /**
     * Get the admin who owns the course.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Returns an array of options for a select list for academy types.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function academyListOptions(bool $includeBlank = false, bool $nameAsKey = true): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::ACADEMIES as $i=>$academy) {
            $options[$nameAsKey ? $academy : $i] = $academy;
        }

        return $options;
    }
}
