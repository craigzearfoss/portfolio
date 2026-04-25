<?php

namespace App\Exports\System;

use App\Models\System\Resource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResourcesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Resource::all();
    }
}
