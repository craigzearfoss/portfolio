<?php

namespace App\Exports\Personal;

use App\Models\Personal\RecipeStep;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecipeStepsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new RecipeStep()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', RecipeStep::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
