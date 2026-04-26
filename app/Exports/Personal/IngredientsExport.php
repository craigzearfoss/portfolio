<?php

namespace App\Exports\Personal;

use App\Models\Personal\Ingredient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IngredientsExport implements FromCollection, WithHeadings
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
        )->select([
            DB::raw('ingredients.id as id'),
            DB::raw('ingredients.full_name as full_name'),
            DB::raw('ingredients.name as name'),
            DB::raw('ingredients.link as link'),
        ]);

        return $query->get();
    }

    /**
     * Column headings for the exported Excel spreadsheet.
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'id',
            'full name',
            'name',
            'link',
        ];
    }
}
