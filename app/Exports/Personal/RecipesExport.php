<?php

namespace App\Exports\Personal;

use App\Models\Personal\Recipe;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecipesExport implements FromCollection, WithHeadings
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
        )->select([
            DB::raw('recipes.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('recipes.name as name'),
            DB::raw('recipes.featured as featured'),
            DB::raw('recipes.author as author'),
            DB::raw('recipes.prep_time as prep_time'),
            DB::raw('recipes.total_time as total_time'),
            DB::raw('recipes.main as main'),
            DB::raw('recipes.side as side'),
            DB::raw('recipes.dessert as dessert'),
            DB::raw('recipes.appetizer as appetizer'),
            DB::raw('recipes.beverage as beverage'),
            DB::raw('recipes.breakfast as breakfast'),
            DB::raw('recipes.lunch as lunch'),
            DB::raw('recipes.dinner as dinner'),
            DB::raw('recipes.snack as snack'),
            DB::raw('recipes.link as link'),
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
            /*'owner_username'*/ 'owner',
            'name',
            'featured',
            'author',
            'prep time',
            'total time',
            'main',
            'side',
            'dessert',
            'appetizer',
            'beverage',
            'breakfast',
            'lunch',
            'dinner',
            'snack',
            'link',
        ];
    }
}
