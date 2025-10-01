<?php

namespace App\Models\Portfolio;

use App\Models\Owner;
use App\Models\Portfolio\Academy;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\CourseFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'featured',
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
    ];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }
    /**
     * Get the owner of the course.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the academy that owns the course.
     */
    public function academy(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Academy::class, 'academy_id');
    }
}
