<?php

namespace App\Models\Career;

use App\Models\Career\CommunicationType;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communication extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CommunicationFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'communications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'communication_type_id',
        'subject',
        'to',
        'from',
        'date',
        'time',
        'body',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'application_id', 'subject', 'to', 'from', 'date', 'time', 'body',
        'public', 'readonly', 'root', 'disabled', 'demo',];
    const SEARCH_ORDER_BY = ['subject', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Get the owner of the communication.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the application that owns the communication.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Get the communication type that owns the communication.
     */
    public function communicationType(): BelongsTo
    {
        return $this->belongsTo(CommunicationType::class, 'communication_type_id')
            ->orderBy('sequence', 'asc');
    }

}
