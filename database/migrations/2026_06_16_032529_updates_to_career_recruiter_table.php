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
        Schema::connection('career_db')->table('recruiters', function (Blueprint $table) {
            $table->integer('founded')->nullable()->after('international');
            $table->string('linkedin_url', 500)->nullable()->after('founded');
        });

        // update recruiters
        $data = [
            1 => [ 'name' => 'Trova', 'slug' => 'trova', 'primary' => 0, 'local' => 0, 'national' => 1, 'international' => 0, 'street' => null, 'city' => 'Winter Park', 'state_id' => 10, 'zip' => null, 'founded' => null, 'link' => 'https://www.trovasearch.com/', 'phone' => '(321) 972-3333', 'email' => 'info@trovasearch.com', 'linkedin_url' => null, 'jobs_url' =>'https://trovasearch.com/job-postings/' ],
            2 => [ 'name' => 'CSS Staffing', 'slug' => 'css-staffing', 'primary' => 0, 'local' => 0, 'national' => 1, 'international' => 0, 'street' => '323 S. Matlack Street, Suite A', 'city' => 'West Chester', 'state_id' => 39, 'zip' => '19342', 'founded' => null, 'link' => 'https://cssstaffing.com/', 'phone' => '(302) 737-4920', 'email' => 'webinquiry@cssstaffing.com', 'linkedin_url' => null, 'jobs_url' =>'https://cssstaffing.com/search-open-positions/' ],
            3 => [ 'name' => 'TalentFish', 'slug' => 'talentfish', 'primary' => 0, 'local' => 0, 'national' => 1, 'international' => 0, 'street' => '1655 Sylvester Place', 'city' => 'Highland Park', 'state_id' => 14, 'zip' => '60035', 'founded' => null, 'link' => 'https://talentfish.com/', 'phone' => '(847) 306-3287', 'email' => 'info@talentfish.com', 'linkedin_url' => null, 'jobs_url' =>'https://talentfish.com/opportunities/' ],
            4 => [ 'name' => 'Robert Half', 'slug' => 'robert-half', 'primary' => 1, 'local' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'city' => 'Menlo Park', 'state_id' => 5, 'zip' => null, 'founded' => 1948, 'link' => 'https://www.roberthalf.com/', 'phone' => null, 'email' => null, 'linkedin_url' => 'https://www.linkedin.com/company/robert-half-international/', 'jobs_url' =>'https://www.roberthalf.com/us/en/find-jobs' ],
            5 => [ 'name' => 'Horizontal Talent', 'slug' => 'horizontal-talent', 'primary' => 0, 'local' => 1, 'national' => 0, 'international' => 0, 'street' => '1660 MN-100, Suite 200', 'city' => 'St. Louis Park', 'state_id' => 24, 'zip' => '55416', 'founded' => null, 'link' => 'https://www.horizontaltalent.com/', 'phone' => '(612) 392-7580', 'email' => null, 'linkedin_url' => null, 'jobs_url' =>'https://www.horizontaltalent.com/job-board' ],
            6 => [ 'name' => 'Ranstad USA', 'slug' => 'ranstad-usa', 'primary' => 1, 'local' => 0, 'national' => 0, 'international' => 1, 'street' => null, 'city' => 'Atlanta', 'state_id' => 11, 'zip' => null, 'founded' => 1960, 'link' => 'https://www.randstadusa.com/', 'phone' => null, 'email' => null, 'linkedin_url' => 'https://www.linkedin.com/company/randstadusa/', 'jobs_url' =>'https://www.randstadusa.com/' ],
            7 => [ 'name' => 'CyberCoders', 'slug' => 'cybercoders', 'primary' => 1, 'local' => 0, 'national' => 1, 'international' => 0, 'street' => null, 'city' => 'Irvine', 'state_id' => null, 'zip' => null, 'founded' => 1999, 'link' => 'https://www.cybercoders.com/', 'phone' => null, 'email' => null, 'linkedin_url' => 'https://www.linkedin.com/company/cybercoders/', 'jobs_url' =>'https://www.cybercoders.com/browse-jobs' ],
            8 => [ 'name' => 'Crossing Hurdles', 'slug' => 'crossing-hurdles', 'primary' => 0, 'local' => 0, 'national' => 1, 'international' => 0, 'street' => null, 'city' => null, 'state_id' => null, 'zip' => null, 'founded' => null, 'link' => 'https://crossinghurdles.com/', 'phone' => null, 'email' => 'support@crossinghurdles.com', 'linkedin_url' => 'https://www.linkedin.com/company/crossinghurdles/', 'jobs_url' => null ],
        ];

        foreach ($data as $id=>$row) {
            if (!$recruiter = new Recruiter()->newQuery()->find($id)) {
                echo PHP_EOL . $id . ') ' . $row['name'] . ' *** NOT FOUND ***';
            }

            foreach ($row as $col=>$val) {
                $recruiter->{$col} = $val;
            }

            $recruiter->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->table('recruiter', function (Blueprint $table) {
            //
        });
    }
};
