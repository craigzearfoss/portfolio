<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\AntiSkill;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AntiSkillsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new AntiSkill()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AntiSkill::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
