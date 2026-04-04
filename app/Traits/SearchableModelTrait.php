<?php

namespace App\Traits;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

/**
 *
 */
trait SearchableModelTrait
{
    const array COMMON_COLUMNS = [
        'id',
        'owner_id',
        'name',
        'slug',
        'featured',
        'summary',
        'primary',
        'street',
        'street2',
        'city',
        'state_id',
        'zip_id',
        'country',
        'phone',
        'alt_phone',
        'email',
        'alt_email',
        'notes',
        'link_name',
        'description',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Returns an array of options for an industry select list.
     *
     * @param array    $filters
     * @param string   $valueColumn
     * @param string   $labelColumn
     * @param mixed    $includeBlank
     * @param bool     $includeOther
     * @param array    $orderBy
     * @param EnvTypes $envType
     * @return array
     * @throws Exception
     */
    public function listOptions(array  $filters = [],
                                string $valueColumn = 'id',
                                string $labelColumn = 'name',
                                mixed  $includeBlank = false,
                                bool   $includeOther = false,
                                array  $orderBy = [],
                                EnvTypes $envType = EnvTypes::GUEST): array
    {
        $predefinedColumns = [];
        $other = null;

        $options = $includeBlank ? [ '' => '' ] : [];

        // set the columns
        $selectColumns = [
            $this->table . '.id',
        ];

        foreach ([$valueColumn, $labelColumn] as $field) {
            if (!empty($field) ) {
                if ($field = $this->fullyQualifiedField($field, $predefinedColumns)) {
                    $selectColumns[] = $field;
                }
            }
        }

        // set the order by
        $sortColumn = $orderBy[0] ?? $this->table . '.' . self::SEARCH_ORDER_BY[0];
        if (!in_array($sortColumn, $selectColumns) && !in_array($sortColumn, $predefinedColumns)) {
            $selectColumns[] = $sortColumn;
        }
        $sortDir = $orderBy[1] ?? self::SEARCH_ORDER_BY[1];

        // create the query
        if ($envType == EnvTypes::ADMIN) {
            $query = new self()->withoutGlobalScope(AdminPublicScope::class)
                ->select($selectColumns)->orderBy($sortColumn, $sortDir);
        } else {
            $query = new self()->distinct()->select($selectColumns)->orderBy($sortColumn, $sortDir);
        }

        // apply filters to the query
        foreach ($filters as $col => $value) {

            // if the filter is owner_id and the value is null then ignore it because owner_id should always have a value
            if (($col == 'owner_id') && empty($value)) {
                continue;
            }

            // make sure common columns are fully qualified to avoid query errors
            if (in_array($col, self::COMMON_COLUMNS)) {
                $col = $this->table . '.' .$col;
            }

            // get the where clause
            if (is_array($value)) {
                $query = $query->whereIn($col, $value);
            } else {
                $parts = explode(' ', $col);
                $col = $parts[0];
                if (!empty($parts[1])) {
                    $operation = trim($parts[1]);
                    if (in_array($operation, ['<>', '!=', '=!'])) {
                        $query->where($col, $operation, $value);
                    } elseif (strtolower($operation) == 'like') {
                        $query->whereLike($col, $value);
                    } else {
                        throw new Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($col, '=', $value);
                }
            }
        }

        foreach ($query->get() as $row) {
            if ($row->{$labelColumn} == 'other') {
                $other = $row;
            } else {
                $options[$row->{$valueColumn}] = $row->{$labelColumn};
            }
        }

        // put the 'other' option last
        if ($includeOther) {
            if (!empty($other)) {
                $options[$other->{$valueColumn}] = $other->{$labelColumn};
            } else {
                $options[] = 'other';
            }
        }

        return $options;
    }

    /**
     * Returns an array with the urls for the previous page and the next page.
     *
     * @param int $id
     * @param string $route
     * @param Admin|Owner|null $owner
     * @param array $orderBy
     * @param array $urlParams
     * @return null[]
     */
    public function prevAndNextPages(int              $id,
                                     string           $route,
                                     Admin|Owner|null $owner = null,
                                     array            $orderBy = ['id', 'asc'],
                                     array            $urlParams = []): array
    {
        $prev = null;
        $next = null;

        $envType = match (explode('.', $route)[0]) {
            'admin' => EnvTypes::ADMIN,
            'guest' => EnvTypes::GUEST,
            'user' => EnvTypes::USER,
            default => null,
        };

        $ownerId = !empty($owner)
            ? $owner->id ?? null
            : null;

        $orderByColumn = is_array($orderBy) ? $orderBy[0] : $orderBy;
        $orderByDirection = is_array($orderBy) ? $orderBy[1] : 'asc';

        $className           = self::class;
        $object              = new $className();
        $databaseTag         = $object->getConnectionName();
        $tableName           = $object->getTable();
        $tableNameWithPrefix = config('app.'.$databaseTag) . '.' . $tableName;
        $tableModel          = new self();

        // determine the previous and next resources
        $query = $tableModel->select('id')->orderBy($orderByColumn, $orderByDirection);

        if (!empty($ownerId) && Schema::hasColumn($tableNameWithPrefix, 'owner_id')) {
            $query->where('owner_id', '=', $ownerId);
        }

        if ($envType == EnvTypes::GUEST) {
            $query->where($this->table . '.is_public', true)
                ->where($this->table . '.is_disabled', false);
        }
        $ids = $query->get()->pluck('id')->toArray();
        if (false !== $key = array_search($id, $ids)) {
            if ($prevId = array_key_exists($key - 1, $ids) ? $ids[$key - 1] : null) {
                $prev = $envType == EnvTypes::GUEST
                    ? route($route, $tableModel->find($prevId))
                    : route($route, $prevId);
            }
            if ($nextId = array_key_exists($key + 1, $ids) ? $ids[$key + 1] : null) {
                $next = $envType == EnvTypes::GUEST
                    ? route($route, $tableModel->find($nextId))
                    : route($route, $nextId);
            }
        }

        foreach ($urlParams as $key=>$value) {
            $urlParams[$key] = urlencode($value);
        }

        return [
            !empty($prev) ? url()->query($prev, $urlParams) : null,
            !empty($next) ? url()->query($next, $urlParams) : null,
        ];
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @return Builder
     */
    public static function searchQuery(array $filters = []): Builder
    {
        return new self()->getSearchQuery($filters);
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Owner|Admin|null $owner
     * @return mixed
     */
    public function getSearchQuery(array $filters = [], Owner|Admin|null $owner = null): mixed
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner['id'];
        }

        return new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where($this->table . '.id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where($this->table . '.owner_id', '=', intval($filters['owner_id']));
            });
    }

    /**
     * Append address column filters to a database query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function appendAddressFilters(Builder $query, array $filters = []): Builder
    {
        $query->when(!empty($filters['city']), function ($query) use ($filters) {
                $query->where($this->table . '.city', 'LIKE', '%' . $filters['city'] . '%');
            })
            ->when(!empty($filters['state_id']), function ($query) use ($filters) {
                $query->where($this->table . '.state_id', '=', intval($filters['state_id']));
            })
            ->when(!empty($filters['zip']), function ($query) use ($filters) {
                $query->where($this->table . '.zip', 'LIKE', '%' . $filters['zip'] . '%');
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where($this->table . '.country_id', '=', intval($filters['country_id']));
            });

        return $query;
    }

    /**
     * Append email column filters to a database query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function appendEmailFilters(Builder $query, array $filters = []): Builder
    {
        $query->when(!empty($filters['email']), function ($query) use ($filters) {
            $email = $filters['email'];
            $query->where(function ($query) use ($email) {
                $query->where($this->table . '.email', 'LIKE', '%' . $email . '%')
                    ->orWhere($this->table . '.alt_email', 'LIKE', '%' . $email . '%');
            });
        });

        return $query;
    }

    /**
     * Append environment column filters to a database query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function appendEnvironmentFilters(Builder $query, array $filters = []): Builder
    {
        $query->when(isset($filters['guest']), function ($query) use ($filters) {
                $query->where($this->table . '.guest', '=', boolval(['guest']));
            })
            ->when(isset($filters['user']), function ($query) use ($filters) {
                $query->where($this->table . '.user', '=', boolval(['user']));
            })
            ->when(isset($filters['admin']), function ($query) use ($filters) {
                $query->where($this->table . '.admin', '=', boolval(['admin']));
            })
            ->when(isset($filters['menu']), function ($query) use ($filters) {
                $query->where($this->table . '.menu', '=', boolval(['menu']));
            })
            ->when(isset($filters['menu_level']), function ($query) use ($filters) {
                $query->where($this->table . '.menu_level', '=', intval(['menu_level']));
            })
            ->when(isset($filters['menu_collapsed']), function ($query) use ($filters) {
                $query->where($this->table . '.menu_collapsed', '=', boolval(['menu_collapsed']));
            });

        return $query;
    }

    /**
     * Append phone column filters to a database query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function appendPhoneFilters(Builder $query, array $filters = []): Builder
    {
        $query->when(!empty($filters['phone']), function ($query) use ($filters) {
            $phone = $filters['phone'];
            $query->where(function ($query) use ($phone) {
                $query->where($this->table . '.phone', 'LIKE', '%' . $phone . '%')
                    ->orWhere($this->table . '.phone_label', 'LIKE', '%' . $phone . '%')
                    ->orWhere($this->table . '.alt_phone', 'LIKE', '%' . $phone . '%')
                    ->orWhere($this->table . '.alt_phone_label', 'LIKE', '%' . $phone . '%');
            });
        });

        return $query;
    }

    /**
     * Append standard column filters to a database query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function appendStandardFilters(Builder $query, array $filters = []): Builder
    {
        $query->when(isset($filters['is_public']), function ($query) use ($filters) {
                $query->where($this->table . '.is_public', '=', boolval(['is_public']));
            })
            ->when(isset($filters['is_readonly']), function ($query) use ($filters) {
                $query->where($this->table . '.is_readonly', '=', boolval(['is_readonly']));
            })
            ->when(isset($filters['is_root']), function ($query) use ($filters) {
                $query->where($this->table . '.is_root', '=', boolval(['is_root']));
            })
            ->when(isset($filters['is_disabled']), function ($query) use ($filters) {
                $query->where($this->table . '.is_disabled', '=', boolval(['is_disabled']));
            })
            ->when(isset($filters['is_demo']), function ($query) use ($filters) {
                $query->where($this->table . '.is_demo', '=', intval(['is_demo']));
            })
            ->when(isset($filters['sequence']), function ($query) use ($filters) {
                $query->where($this->table . '.sequence', '=', intval(['sequence']));
            });

        return $query;
    }

    /**
     * Append timestamp column filters to a database query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function appendTimestampFilters(Builder $query, array $filters = []): Builder
    {
        $query->when(!empty($filters['created_at_from']), function ($query) use ($filters) {
            $query->where($this->table . '.created_at', '>=', $filters['created_at_from']);
        })
        ->when(!empty($filters['created_at_to']), function ($query) use ($filters) {
            $query->where($this->table . '.created_at', '<=', $filters['created_at_to']);
        })
        ->when(!empty($filters['deleted_at_from']), function ($query) use ($filters) {
            $query->where($this->table . '.deleted_at', '>=', $filters['deleted_at_from']);
        })
        ->when(!empty($filters['deleted_at_to']), function ($query) use ($filters) {
            $query->where($this->table . '.deleted_at', '<=', $filters['deleted_at_to']);
        })
        ->when(!empty($filters['updated_at_from']), function ($query) use ($filters) {
            $query->where($this->table . '.updated_at', '>=', $filters['updated_at_from']);
        })
        ->when(!empty($filters['updated_at_to']), function ($query) use ($filters) {
            $query->where($this->table . '.updated_at', '<=', $filters['updated_at_to']);
        });

        return $query;
    }

    /**
     * Removes empty values from a $filters array like when owner_id=0.
     *
     * @param array $filters
     * @return array
     */
    public function removeEmptyFilters(array $filters): array
    {
        if (array_key_exists('owner_id', $filters) && empty($filters['owner_id'])) {
            unset($filters['owner_id']);
        }

        return $filters;
    }

    public function fullyQualifiedField($field, array $predefinedColumns = []): string|null
    {
        if (empty($field)) {
            return null;
        } elseif (in_array($field, $predefinedColumns)) {
            return $field;
        }

        return strpos($field, '.')
            ? $field
            : $this->table . '.' . $field;
    }
}
