<?php

use App\Models\Career\Recruiter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $data = [
            [ 'name' => 'Dynamite Jobs', 'slug' => 'dynamite-jobs', 'primary' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => 'Austin', 'state_id' => 44, 'zip' => '78749', 'country_id' => 237, 'founded' => 2017, 'link' => 'https://dynamitejobs.com/', 'phone' => '(512) 489-0380', 'email' => 'team@dynamitejobs.com', 'linkedin_url' => 'https://www.linkedin.com/company/dynamite-jobs/', 'jobs_url' => 'https://dynamitejobs.com/remote-jobs', 'recruiter_industry_id' => 4 ],
            [ 'name' => 'World Wide Technology', 'slug' => 'world-wide-technology', 'primary' => 0, 'national' => 0, 'international' => 1, 'street' => '1 World Wide Way', 'street2' => null, 'city' => 'Maryland Heights', 'state_id' => 21, 'zip' => '63146', 'country_id' => 237, 'founded' => null, 'link' => 'https://www.wwt.com/', 'phone' => '(314) 569-7000', 'email' => null, 'linkedin_url' => 'https://www.linkedin.com/company/world-wide-technology/', 'jobs_url' => 'https://myjobs.adp.com/wwtexternalcareersite/cx', 'recruiter_industry_id' => 6 ],
            [ 'name' => 'Hire Feed', 'slug' => 'hire-feed', 'primary' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => null, 'state_id' => null, 'zip' => null, 'country_id' => 237, 'founded' => null, 'link' => 'https://www.hirefeed.co.in/', 'phone' => null, 'email' => 'info@quik-hire.com', 'linkedin_url' => 'https://www.linkedin.com/company/hirefeedd/', 'jobs_url' => 'https://joblet.ai/jobs', 'recruiter_industry_id' => 8 ],
            [ 'name' => 'Oscar', 'slug' => 'oscar', 'primary' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => 'Manchester', 'state_id' => null, 'zip' => null, 'country_id' => 234, 'founded' => 2001, 'link' => 'https://www.oscar-recruit.com/us', 'phone' => '0161 828 8140', 'email' => null, 'linkedin_url' => 'https://www.linkedin.com/company/oscar/', 'jobs_url' => 'https://www.oscar-recruit.com/us/jobs', 'recruiter_industry_id' => 8 ],
            [ 'name' => 'Hospital Staffing Partners LLC', 'slug' => 'hospital-staffing-partners-llc', 'primary' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => null, 'state_id' => null, 'zip' => null, 'country_id' => 237, 'founded' => 2022, 'link' => 'https://hospitalstaffingpartners.com/', 'phone' => '(561) 789-4409', 'email' => null, 'linkedin_url' => 'https://www.linkedin.com/company/hospital-staffing-partners-llc/', 'jobs_url' => 'https://hospitalstaffingpartners.com/jobs', 'recruiter_industry_id' => 8 ],
        ];

        for ($i=0; $i<count($data); $i++) {
            $data[$i]['created_at'] = date('Y-m-m H:i:s');
            $data[$i]['updated_at'] = date('Y-m-m H:i:s');

            DB::connection('career_db')->table('recruiters')->insert($data[$i]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
