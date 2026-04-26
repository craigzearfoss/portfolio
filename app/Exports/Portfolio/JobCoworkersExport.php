<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\JobCoworker;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobCoworkersExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new JobCoworker()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobCoworker::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
