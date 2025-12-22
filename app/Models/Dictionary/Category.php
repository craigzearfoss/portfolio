<?php

namespace App\Models\Dictionary;

use App\Models\Portfolio\JobSkill;
use App\Models\Portfolio\Skill;
use App\Models\Scopes\AdminPublicScope;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SearchableModelTrait;

    protected $connection = 'dictionary_db';

    protected $table = 'categories';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'name',
        'slug',
        'abbreviation',
        'definition',
        'open_source',
        'proprietary',
        'compiled',
        'owner',
        'wikipedia',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'public',
        'readonly',
        'root',
        'disabled',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'name', 'full_name', 'abbreviation', 'open_source', 'proprietary', 'compiled', 'owner'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Get the job skills for the category.
     */
    public function jobSkills(): HasMany
    {
        return $this->hasMany(JobSkill::class, 'dictionary_category_id')
            ->orderBy('id', 'asc');
    }

    /**
     * Get the skills for the category.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'dictionary_category_id')
            ->orderBy('id', 'asc');
    }
}
