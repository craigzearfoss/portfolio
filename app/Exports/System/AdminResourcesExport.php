<?php

namespace App\Exports\System;

use App\Models\System\AdminResource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminResourcesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return AdminResource::all();
    }
}
