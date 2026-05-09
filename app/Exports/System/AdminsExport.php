<?php

namespace App\Exports\System;

use App\Models\System\Admin;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Admin()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Admin::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
