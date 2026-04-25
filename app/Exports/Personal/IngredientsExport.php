<?php

namespace App\Exports\Personal;

use App\Models\Personal\Ingredient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class IngredientsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new Ingredient()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Ingredient::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
