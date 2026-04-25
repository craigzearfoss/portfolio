<?php

namespace App\Exports\System;

use App\Models\System\LoginAttemptsUser;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoginAttemptsUserExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new LoginAttemptsUser()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', LoginAttemptsUser::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
