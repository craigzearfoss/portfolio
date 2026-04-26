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
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [
        'owner_name', 'owner_username', 'owner_email'
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'owner_id', 'from_admin', 'name', 'email', 'subject', 'body', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo', 'created_at', 'updated_at'
    ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'created_at', 'desc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'created_at|desc'    => 'datetime created',
        'updated_at|desc'    => 'datetime updated',
        'email|asc'          => 'email',
        'name|asc'           => 'name',
        //'owner_username|asc' => 'owner',      // owner_username is always root
        //'owner_id|asc'       => 'id owner',   // owner_id is always 1
        'subject|asc'        => 'subject',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'created_at', 'email', 'name', 'subject', ],
        'guest' => [ 'created_at', 'email', 'name', 'subject', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
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

        $query = $this->getSearchQuery($filters, $owner)
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
