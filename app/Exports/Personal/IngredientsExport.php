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
        return Ingredient::all();
    }
}
