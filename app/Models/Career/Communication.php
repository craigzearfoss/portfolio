<?php

namespace App\Models\Career;

use App\Models\Career\CommunicationType;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = self::when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['application_id']), function ($query) use ($filters) {
                $query->where('application_id', '=', intval($filters['application_id']));
            })
            ->when(!empty($filters['communication_type_id']), function ($query) use ($filters) {
                $query->where('communication_type_id', '=', intval($filters['communication_type_id']));
            })
            ->when(!empty($filters['subject']), function ($query) use ($filters) {
                $query->where('subject', 'like', '%' . $filters['subject'] . '%');
            })
            ->when(!empty($filters['to']), function ($query) use ($filters) {
                $query->where('to', 'like', '%' . $filters['to'] . '%');
            })
            ->when(!empty($filters['from']), function ($query) use ($filters) {
                $query->where('from', 'like', '%' . $filters['from'] . '%');
            })
            ->when(!empty($filters['body']), function ($query) use ($filters) {
                $query->where('body', 'like', '%' . $filters['body'] . '%');
            })
            ->when(!empty($filters['date']), function ($query) use ($filters) {
                $query->where('date', '=', $filters['date']);
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });

        return $query;
    }

    /**
     * Get the system owner of the communication.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application that owns the communication.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }

    /**
     * Get the career communication type that owns the communication.
     */
    public function communicationType(): BelongsTo
    {
        return $this->belongsTo(CommunicationType::class, 'communication_type_id')
            ->orderBy('sequence', 'asc');
    }

}
