<?php

namespace App\Exports\System;

use App\Models\System\ResourceSetting;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResourceSettingsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return ResourceSetting::all();
    }
}
