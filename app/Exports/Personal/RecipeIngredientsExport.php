<?php

namespace App\Exports\Personal;

use App\Models\Personal\RecipeIngredient;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecipeIngredientsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new RecipeIngredient()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', RecipeIngredient::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
