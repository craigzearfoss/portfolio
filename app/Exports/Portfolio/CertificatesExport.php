<?php

namespace App\Exports\Portfolio;

use App\Models\Career\Application;
use App\Models\Portfolio\Certificate;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CertificatesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Certificate()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Certificate::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
