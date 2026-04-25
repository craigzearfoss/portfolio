<?php

namespace App\Exports\Career;

use App\Models\Career\CoverLetter;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CoverLettersExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new CoverLetter()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', CoverLetter::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
