<?php

namespace App\Models\Portfolio;

use App\Models\Portfolio\Certification;
use App\Models\Portfolio\Course;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Academy extends Model
{
    use SearchableModelTrait;

    protected $connection = 'portfolio_db';

    protected $table = 'academies';

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
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'name', 'primary', 'local', 'regional', 'national', 'international', 'public'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the certifications for the academy.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the courses for the academy.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
