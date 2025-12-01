<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
     * @return array
     * @throws \Exception
     */
    public static function listOptions(array  $filters = [],
                                       string $valueColumn = 'id',
                                       string $labelColumn = 'name',
                                       bool   $includeBlank = false,
                                       bool   $includeOther = false,
                                       array  $orderBy = self::SEARCH_ORDER_BY): array
    {
        $other = null;

        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $selectColumns = self::SEARCH_COLUMNS ?? [$valueColumn, $labelColumn];
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        $query = self::select($selectColumns)->orderBy($sortColumn, $sortDir);

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
}
