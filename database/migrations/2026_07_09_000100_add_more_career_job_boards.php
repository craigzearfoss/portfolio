<?php

use App\Models\Career\JobBoard;
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
            [ 'primary' => 0, 'founded' => 2022, 'recruiter_id' => null, 'name' => 'Feedcoyote', 'slug' => 'feedcoyote', 'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => null, 'state_id' => null, 'zip' => null, 'country_id' => 237, 'link' => 'https://feedcoyote.com/', 'linkedin_url' => 'https://www.linkedin.com/company/feedcoyote/', 'jobs_url' => null, 'phone' => null, 'email' => null, 'recruiter_industry_id' => 1, 'specialties' => 'crm|network|entrepreneurs|freelancers|software|independent contractors|business owners|gig workers|management|work efficiency|productivity|scalability|b2c saas|collaboration|b2b saas|automation|integrations|all-in-one|growth|partnership|increase profits|techstars' ],
            [ 'primary' => 0, 'founded' => 2017 , 'recruiter_id' => 85, 'name' => 'Dynamite Jobs', 'slug' => 'dynamite-jobs', 'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => 'Austin', 'state_id' => 44, 'zip' => '78749', 'country_id' => 237, 'link' => 'https://www.dynamitejobs.com', 'linkedin_url' => 'https://www.linkedin.com/company/dynamite-jobs/', 'jobs_url' => 'https://dynamitejobs.com/remote-jobs', 'phone' => null, 'email' => 'team@dynamitejobs.com', 'recruiter_industry_id' => 1, 'specialties' => 'human resources and recruiting' ],
            [ 'primary' => 0, 'founded' => null, 'recruiter_id' => null, 'name' => 'JobBoardSearch', 'slug' => 'jobboardsearch', 'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 0, 'street' => null, 'street2' => null, 'city' => null, 'state_id' => null, 'zip' => null, 'country_id' => 237, 'link' => 'https://jobboardsearch.com/', 'linkedin_url' => null, 'jobs_url' => 'https://jobboardsearch.com/', 'phone' => null, 'email' => null, 'recruiter_industry_id' => 1, 'specialties' => null ],
            [ 'primary' => 0, 'founded' => null, 'recruiter_id' => null, 'name' => 'NoDesk', 'slug' => 'nodesk', 'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => null, 'state_id' => 33, 'zip' => null, 'country_id' => 237, 'link' => 'https://nodesk.co/', 'linkedin_url' => 'https://www.linkedin.com/company/nodeskco/', 'jobs_url' => 'https://nodesk.co/remote-jobs/', 'phone' => null, 'email' => null, 'recruiter_industry_id' => 1, 'specialties' => 'remotejobs|remotejob|work from home|nomad' ],
            [ 'primary' => 0, 'founded' => null, 'recruiter_id' => null, 'name' => 'RemoteJobs.io', 'slug' => 'remotejobs-io', 'local' => 0, 'regional' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'street2' => null, 'city' => null, 'state_id' => null, 'zip' => null, 'country_id' => 237, 'link' => 'https://www.remotejobs.io/', 'linkedin_url' => 'https://www.linkedin.com/company/remotejobs-io/', 'jobs_url' => 'https://www.remotejobs.io/curate-search/how-it-works-2', 'phone' => null, 'email' => null, 'recruiter_industry_id' => 1, 'specialties' => 'remote jobs|hybrid jobs|job site|job board, flexibility|work-life balance|flexible work|remote work|work from home|work from home jobs|career advice|job search|job hunting|job listings|remote job listings|hybrid job listings' ],
        ];

        for ($i=0; $i<count($data); $i++) {
            $data[$i]['created_at'] = date('Y-m-m H:i:s');
            $data[$i]['updated_at'] = date('Y-m-m H:i:s');

            DB::connection('career_db')->table('job_boards')->insert($data[$i]);
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
