<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Course;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CoursesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Course::all();
    }
}
