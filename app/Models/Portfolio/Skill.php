<?php

namespace App\Models\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\SkillFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'version',
        'featured',
        'rating',
        'category_id',
        'start_year',
        'years',
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
     * Get the owner of the skill.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the dictionary category that owns the admin.
     */
    public function category(): BelongsTo
    {
        return $this->setConnection('dictionary_db')->belongsTo(Category::class, 'category_id');
    }
}
