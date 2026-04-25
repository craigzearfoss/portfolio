<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\JobSkill;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobSkillsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JobSkill::all();
    }
}
