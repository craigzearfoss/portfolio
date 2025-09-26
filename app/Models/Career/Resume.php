<?php

namespace App\Models\Career;

use App\Models\Admin;
use App\Models\Career\Application;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ResumeFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'resumes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'date',
        'primary',
        'content',
        'doc_url',
        'pdf_url',
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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the admin who owns the resume.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the career applications for the career resume.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class)->orderBy('post_date', 'desc');
    }

    /**
     * Returns an array of options for a select list for resumes.
     *
     * @param int | null $adminId
     * @param bool $includeBlank
     * @return array|string[]
     */
    public static function listOptions(int | null $adminId = null, bool $includeBlank = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $query = Resume::orderBy('date', 'desc')->orderBy('name', 'asc');

        if (!empty($adminId)) {
            $query->where('resumes.admin_id', $adminId);
        }

        foreach ($query->get() as $resume) {
            $options[$resume->id] = $resume->name . ($resume->primary ? '*' : '') . ' - ' . '  (' . $resume->date . ')';
        }

        return $options;
    }
}
