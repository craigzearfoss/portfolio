<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Skill;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SkillsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Skill::all();
    }
}
