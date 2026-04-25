<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\JobSkill;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobSkillsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return JobSkill::all();
    }
}
