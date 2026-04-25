<?php

namespace App\Exports\Personal;

use App\Models\Personal\Recipe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecipesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Recipe::all();
    }
}
