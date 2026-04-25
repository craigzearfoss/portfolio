<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Certification;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CertificationsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Certification()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Certification::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
