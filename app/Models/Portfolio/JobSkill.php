<?php

namespace App\Models\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class JobSkill extends Model
{
    use SearchableModelTrait, Notifiable, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'job_skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'job_id',
        'name',
        'type', // 0=soft skill, 1=hard skill
        'dictionary_category_id',
        'dictionary_term_id',
        'summary',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['owner_id', 'job_id', 'name', 'type', 'dictionary_category_id', 'dictionary_term_id',
        'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Get the system owner of the job skill.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the dictionary category that owns the job skill.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'dictionary_category_id');
    }

    /**
     * Get the career job of that owns the job skill.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
