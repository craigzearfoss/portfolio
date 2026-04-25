<?php

namespace App\Exports\System;

use App\Models\System\SiteSetting;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiteSettingsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return SiteSetting::all();
    }
}
