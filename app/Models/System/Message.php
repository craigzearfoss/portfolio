<?php

namespace App\Models\System;

use App\Traits\SearchableModelTrait;
use Database\Factories\Career\ApplicationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Message extends Model
{
    /** @use HasFactory<ApplicationFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'from_admin',
        'name',
        'email',
        'subject',
        'body',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'from_admin', 'name', 'email', 'subject', 'body', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'created_at', 'desc' ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->predefinedColumns = [];
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param string|null $sort - column for sort order, append "|asc" or "|desc" to specify direction
     * @param Admin|Owner|null $owner
     * @param User|null $user
     * @return Builder
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['body']), function ($query) use ($filters) {
                $query->where($this->table . '.body', 'like', '%' . $filters['body'] . '%');
            })
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $query->where($this->table . '.email', 'like', '%' . $filters['email'] . '%');
            })
            ->when(!empty($filters['from_admin']), function ($query) use ($filters) {
                $query->where($this->table . '.from_admin', '=', true);
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['subject']), function ($query) use ($filters) {
                $query->where($this->table . '.subject', 'like', '%' . $filters['subject'] . '%');
            });

        $query = $this->appendStandardFilters($query, $filters);
        $query =  $this->appendTimestampFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }
}
