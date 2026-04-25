<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Project::all();
    }
}
