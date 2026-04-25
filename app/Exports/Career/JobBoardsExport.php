<?php

namespace App\Exports\Career;

use App\Models\Career\JobBoard;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobBoardsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new JobBoard()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobBoard::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
