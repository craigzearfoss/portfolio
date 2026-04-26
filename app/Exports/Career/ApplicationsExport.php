<?php

namespace App\Exports\Career;

use App\Models\Career\Application;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Application()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Application::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('applications.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('companies.name as company'),
            DB::raw('applications.role as role'),
            DB::raw('applications.active as active'),
            DB::raw('applications.rating as rating'),
            DB::raw('applications.post_date as posted'),
            DB::raw('applications.apply_date as applied'),
            DB::raw('applications.close_date as closed'),
            DB::raw('job_boards.name as job_board'),
            DB::raw('job_duration_types.name as duration_type'),
            DB::raw('job_location_types.name as location_type'),
            DB::raw('job_employment_types.name as employment_type'),
            DB::raw('applications.city as city'),
            //DB::raw('states.name as state_name'),
            DB::raw('states.code as state_code'),
            DB::raw('applications.zip as zip'),
            //DB::raw('countries.name as country_name'),
            //DB::raw('countries.m49 as country_m49'),
            DB::raw('countries.iso_alpha3 as iso_alpha3'),
            DB::raw('applications.bonus as bonus'),
            DB::raw('applications.w2 as w2'),
            DB::raw('applications.relocation as relocation'),
            DB::raw('applications.benefits as benefits'),
            DB::raw('applications.vacation as vacation'),
            DB::raw('applications.health as health'),
            DB::raw('applications.phone as phone'),
            DB::raw('applications.alt_phone as alt_phone'),
            DB::raw('applications.email as email'),
            DB::raw('applications.alt_email as alt_email'),
            DB::raw('applications.link as link'),
        ]);

        return $query->get();
    }

    /**
     * Column headings for the exported Excel spreadsheet.
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'id',
            /*'owner_username'*/ 'owner',
            'company',
            'role',
            'active',
            'rating',
            'posted',
            'applied',
            'closed',
            'job board',
            'duration',
            'location',
            'employment',
            'city',
            //'state_name',
            /*'state_code'*/ 'state',
            'zip',
            //'country_name',
            //'country_m49',
            /*'country_iso_alpha3'*/ 'country',
            'bonus',
            'w2',
            'relocation',
            'benefits',
            'vacation',
            'health',
            'phone',
            'alt phone',
            'email',
            'alt email',
            'link',
        ];
    }
}
