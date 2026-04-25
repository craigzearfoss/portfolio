<?php

namespace App\Exports\Career;

use App\Models\Career\Recruiter;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecruitersExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Recruiter()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Recruiter::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
