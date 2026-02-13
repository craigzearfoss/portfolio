<?php

namespace App\Traits;

use App\Enums\EnvTypes;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
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
     * @param array $filters
     * @param string $valueColumn
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther
     * @param array $orderBy
     * @param EnvTypes $envType
     * @return array
     * @throws \Exception
     */
    public static function listOptions(array    $filters = [],
                                       string   $valueColumn = 'id',
                                       string   $labelColumn = 'name',
                                       bool     $includeBlank = false,
                                       bool     $includeOther = false,
                                       array    $orderBy = self::SEARCH_ORDER_BY,
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
            $query = self::withoutGlobalScope(\App\Models\Scopes\AdminPublicScope::class)
                ->select($selectColumns)->orderBy($sortColumn, $sortDir);
        } else {
            $query = self::select($selectColumns)->orderBy($sortColumn, $sortDir);
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
                        throw new \Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
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
     * Returns a builder Eloquent Builder object for a search.
     *
     * @param array $filters
     * @param array $orderBy
     * @return Builder
     * @throws \Exception
     */
    public static function searchBuilder(array $filters = [], array $orderBy = self::SEARCH_ORDER_BY): Builder
    {
        $selectColumns = self::SEARCH_COLUMNS ?? ['id', 'name'];
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        $query = self::select($selectColumns)->orderBy($sortColumn, $sortDir);

        // Apply filters to the query.
        foreach ($filters as $col => $value) {
            if (!empty($value)) {
                if (is_array($value)) {
                    $query = $query->whereIn($col, $value);
                } else {
                    $parts = explode(' ', $col);
                    $col = $parts[0];
                    if (in_array($col, $selectColumns)) {
                        if (!empty($parts[1])) {
                            $operation = trim($parts[1]);
                            if (in_array($operation, ['<>', '!=', '=!'])) {
                                $query->where($col, $operation, $value);
                            } elseif (strtolower($operation) == 'like') {
                                $query->whereLike($col, $value);
                            } else {
                                throw new \Exception('Invalid select list filter column: ' . $col . ' ' . $operation);
                            }
                        } else {
                            $query = $query->where($col, $value);
                        }
                    }
                }
            }
        }

        return $query;
    }

    /**
     * Returns the results of a search.
     *
     * @param array $filters
     * @param array $orderBy
     * @return Collection
     * @throws \Exception
     */
    public static function search(array $filters = [], array $orderBy = self::SEARCH_ORDER_BY): Collection
    {
        return self::searchBuilder($filters, $orderBy)->get();
    }

    /**
     * Returns an array with the urls for the previous page and the next page.
     *
     * @param int $id
     * @param string $route
     * @param string|null $ownerId
     * @param array $orderBy
     * @return null[]
     */
    public static function prevAndNextPages(int         $id,
                                            string      $route,
                                            string|null $ownerId = null,
                                            array       $orderBy = ['id', 'asc']): array
    {
        $prev = null;
        $next = null;

        $orderByColumn = is_array($orderBy) ? $orderBy[0] : $orderBy;
        $orderByDirection = is_array($orderBy) ? $orderBy[1] : 'asc';

        $className = self::class;
        $object = new $className();
        $databaseTag = $object->getConnectionName();
        $tableName = $object->getTable();

        // determine the previous and next resumes
        $query = self::select('id')->orderBy($orderByColumn, $orderByDirection);

        if (!empty($ownerId)
            && Schema::hasColumn(config('app.'.$databaseTag) . '.' . $tableName, 'owner_id')
        ) {
            $query->where('owner_id', $ownerId);
        }

        $ids = $query->get()->pluck('id')->toArray();
        if ($key = array_search($id, $ids)) {
            if ($prevId = array_key_exists($key - 1, $ids) ? $ids[$key - 1] : null) {
                $prev = route($route, $prevId);
            }
            if ($nextId = array_key_exists($key + 1, $ids) ? $ids[$key + 1] : null) {
                $next = route($route, $nextId);
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
        return self::searchQuery($filters);
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Owner|Admin|null $owner
     * @return Builder
     */
    public static function getSearchQuery(array $filters = [], Owner|Admin|null $owner = null): Builder
    {
        $query = self::when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', $filters['id']);
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });

        return $query;
    }
}
