<?php

namespace App\Exports\System;

use App\Models\System\LoginAttemptsAdmin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoginAttemptsAdminExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new LoginAttemptsAdmin()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', LoginAttemptsAdmin::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
