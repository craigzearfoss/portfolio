<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Skill;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SkillsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Skill()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Skill::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
