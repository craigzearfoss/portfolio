<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Course;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CoursesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Course()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Course::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
