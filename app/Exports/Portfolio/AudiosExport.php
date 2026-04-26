<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Audio;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AudiosExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Audio()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Audio::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
