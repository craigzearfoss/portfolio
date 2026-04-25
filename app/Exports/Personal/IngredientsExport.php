<?php

namespace App\Exports\Personal;

use App\Models\Personal\Ingredient;
use Maatwebsite\Excel\Concerns\FromCollection;

class IngredientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ingredient::all();
    }
}
