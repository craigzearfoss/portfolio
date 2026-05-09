<?php

namespace App\Exports\System;

use App\Models\System\UserEmail;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserEmailsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new UserEmail()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', UserEmail::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
