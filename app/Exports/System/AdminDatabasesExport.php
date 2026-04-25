<?php

namespace App\Exports\System;

use App\Models\System\AdminDatabase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminDatabasesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new AdminDatabase()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AdminDatabase::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
