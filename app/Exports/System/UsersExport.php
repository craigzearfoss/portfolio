<?php

namespace App\Exports\System;

use App\Models\System\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new User()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', User::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
