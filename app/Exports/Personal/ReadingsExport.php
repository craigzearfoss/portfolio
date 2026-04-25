<?php

namespace App\Exports\Personal;

use App\Models\Personal\Reading;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReadingsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Reading()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Reading::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
