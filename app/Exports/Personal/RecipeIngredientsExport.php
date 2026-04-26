<?php

namespace App\Exports\Personal;

use App\Models\Personal\RecipeIngredient;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecipeIngredientsExport implements FromCollection, WithHeadings
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
            !isRootAdmin() ? loggedInAdmin() : null
        );

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
            'username',
            'company',
            'role',
            'active',
            'rating',
            'posted',
            'applied',
            'closed',
            'job board',
            'duration',
            'location',
            'employment',
            'city',
            //'state_name',
            /*'state_code'*/ 'state',
            //'country_name',
            //'country_m49',
            /*'country_iso_alpha3'*/ 'country',
            'bonus',
            'w2',
            'relocation',
            'benefits',
            'vacation',
            'health',
            'phone',
            'alt phone',
            'email',
            'alt email',
            'link',
        ];
    }
}
