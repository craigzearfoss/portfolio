<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Portfolio\Academy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\CourseFactory> */
    use HasFactory;

    protected $connection = 'portfolio_db';

    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'professional',
        'personal',
        'year',
        'completed',
        'completion_date',
        'duration_hours',
        'academy_id',
        'school',
        'instructor',
        'sponsor',
        'certificate_url',
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
     * Get the admin who owns the course.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the academy that owns the course.
     */
    public function academy(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Academy::class, 'academy_id');
    }
}
