<?php

namespace App\Models\Career;

use App\Models\Career\Application;
use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\Career\NoteFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'name',
        'date',
        'time',
        'location',
        'description',
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
     * Get the owner of the career event.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }


    /**
     * Get the career application that owns career event.
     */
    public function application(): BelongsTo
    {
        return $this->setConnection('core_db')
            ->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }
}
