<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\JobSkill;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobSkillsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new JobSkill()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobSkill::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
