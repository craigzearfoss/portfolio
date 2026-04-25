<?php

namespace App\Exports\Personal;

use App\Models\Personal\Recipe;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecipesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Recipe()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Recipe::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
