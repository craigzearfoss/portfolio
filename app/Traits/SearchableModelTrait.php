<?php

namespace App\Traits;

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
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       string $valueColumn = 'id',
                                       string $labelColumn = 'name',
                                       bool $includeBlank = false,
                                       bool $includeOther = false,
                                       array $orderBy = self::SEARCH_ORDER_BY): array
    {
        $other = null;

        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $selectColumns = self::SEARCH_COLUMNS ?? ['id', 'name'];
        $sortColumn = $orderBy[0] ?? 'name';
        $sortDir = $orderBy[1] ?? 'asc';

        $query = self::select($selectColumns)->orderBy($sortColumn, $sortDir);
        foreach ($filters as $col => $value) {
            $query = $query->where($col, $value);
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
}
