<?php

namespace App\Traits;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 *
 */
trait SearchableModelTrait
{
    /**
     * Returns an array of options for an industry select list.
     *
     * @param array    $filters
     * @param string   $valueColumn
     * @param string   $labelColumn
     * @param bool     $includeBlank
     * @param bool     $includeOther
     * @param array    $orderBy
     * @param EnvTypes $envType
     * @return array
     * @throws Exception
     */
    public function listOptions(array  $filters = [],
                                string $valueColumn = 'id',
                                string $labelColumn = 'name',
                                bool   $includeBlank = false,
                                bool   $includeOther = false,
                                array  $orderBy = self::SEARCH_ORDER_BY,
                                EnvTypes $envType = EnvTypes::GUEST): array
    {
        $other = null;

        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $selectColumns = self::SEARCH_COLUMNS ?? [$valueColumn, $labelColumn];
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        if ($envType == EnvTypes::ADMIN) {
            $query = new self()->withoutGlobalScope(\App\Models\Scopes\AdminPublicScope::class)
                ->select($selectColumns)->orderBy($sortColumn, $sortDir);
        } else {
            $query = new self()->select($selectColumns)->orderBy($sortColumn, $sortDir);
        }

        // Apply filters to the query.
        foreach ($filters as $col => $value) {
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
                    $query = $query->where($col, $value);
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

        // Put the 'other' option last.
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
     * @return null[]
     */
    public function prevAndNextPages(int              $id,
                                     string           $route,
                                     Admin|Owner|null $owner = null,
                                     array            $orderBy = ['id', 'asc']): array
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
            $query->where('owner_id', $ownerId);
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

        return [$prev, $next];
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
        return new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });
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
            $query->where('guest', '=', boolval(['guest']));
        })
            ->when(isset($filters['user']), function ($query) use ($filters) {
                $query->where('user', '=', boolval(['user']));
            })
            ->when(isset($filters['admin']), function ($query) use ($filters) {
                $query->where('admin', '=', boolval(['admin']));
            })
            ->when(isset($filters['menu']), function ($query) use ($filters) {
                $query->where('menu', '=', boolval(['menu']));
            })
            ->when(isset($filters['menu_level']), function ($query) use ($filters) {
                $query->where('menu_level', '=', intval(['menu_level']));
            })
            ->when(isset($filters['menu_collapsed']), function ($query) use ($filters) {
                $query->where('menu_collapsed', '=', boolval(['menu_collapsed']));
            });

        return $query;
    }

    /**
     * Append standard column filters to a database query.
     *
     * @param Builder $query
     * @param array $filters
     * @param bool $includeDemo
     * @return Builder
     */
    public function appendStandardFilters(Builder $query, array $filters = [], bool $includeDemo = true): Builder
    {
        $query->when(isset($filters['public']), function ($query) use ($filters) {
            $query->where('public', '=', boolval(['public']));
        })
        ->when(isset($filters['readonly']), function ($query) use ($filters) {
            $query->where('readonly', '=', boolval(['readonly']));
        })
        ->when(isset($filters['root']), function ($query) use ($filters) {
            $query->where('root', '=', boolval(['root']));
        })
        ->when(isset($filters['disabled']), function ($query) use ($filters) {
            $query->where('disabled', '=', boolval(['disabled']));
        })
        ->when(isset($filters['sequence']), function ($query) use ($filters) {
            $query->where('sequence', '=', intval(['sequence']));
        });

        if ($includeDemo) {
           $query->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', intval(['demo']));
            });
        }

        return $query;
    }
}
