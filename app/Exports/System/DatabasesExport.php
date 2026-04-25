<?php

namespace App\Exports\System;

use App\Models\System\Database;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DatabasesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Database::all();
    }
}
