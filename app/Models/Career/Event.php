<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\Career\NoteFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

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
        'attendees',
        'description',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'application_id', 'name', 'date', 'time', 'location', 'attendees',
        'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['subject', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }
    /**
     * Get the system owner of the event.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }


    /**
     * Get the career application that owns event.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }
}
