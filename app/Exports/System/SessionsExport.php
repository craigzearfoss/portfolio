<?php

namespace App\Exports\System;

use App\Models\System\Session;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SessionsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new Session()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Session::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
