<?php

use App\Models\Career\Recruiter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('recruiters', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('postings_url')->nullable();
            $table->boolean('local')->default(false);
            $table->boolean('regional')->default(false);
            $table->boolean('national')->default(false);
            $table->boolean('international')->default(false);
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable();
            $table->foreignId('state_id')
                ->nullable()
                ->constrained($systemDbName.'.states', 'id')
                ->onDelete('cascade');
            $table->string('zip', 20)->nullable();
            $table->foreignId('country_id')
                ->nullable()
                ->constrained($systemDbName.'.countries', 'id')
                ->onDelete('cascade');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 255)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 255)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 255)->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'            => 1,
                'name'          => 'Trova',
                'slug'          => '',
                'postings_url'  => 'https://www.trovasearch.com/job-postings/',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'          => '',
                'link_name'     => null,
                'phone'         => '(321) 972-3333',
                'email'         => 'info@trovasearch.com',
                'street'        => null,
                'street2'       => null,
                'city'          => 'Winter Park',
                'state_id'      => 10,
                'zip'           => '60035',
                'country_id'   => 237,
            ],
            [
                'id'            => 2,
                'name'          => 'CSS Staffing',
                'slug'          => 'css-staffing',
                'postings_url'  => 'https://cssstaffing.com/search-open-positions/',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'          => 'https://cssstaffing.com/',
                'link_name'     => null,
                'phone'         => '(302) 737-4920',
                'email'         => 'support@cssstaffing.com',
                'street'        => '323 S. Matlack Street, Suite A',
                'street2'       => null,
                'city'          => 'West Chester',
                'state_id'      => 39,
                'zip'           => '19342',
                'country_id'    => 237,
            ],
            [
                'id'            => 3,
                'name'          => 'TalentFish',
                'slug'          => 'talentfish',
                'postings_url'  => 'https://talentfish.com/opportunities/',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'          => 'https://talentfish.com/',
                'link_name'     => null,
                'phone'         => '(847) 306-3287',
                'email'         => 'info@talentfish.com',
                'street'        => '1655 Sylvester Place',
                'street2'       => null,
                'city'          => 'Highland Park',
                'state_id'      => 14,
                'zip'           => '60035',
                'country_id'    => 237,
            ],
            [
                'id'            => 4,
                'name'          => 'Robert Half',
                'slug'          => 'robert-half',
                'postings_url'  => 'https://www.roberthalf.com/us/en/jobs',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'          => 'https://www.roberthalf.com/us/en',
                'link_name'     => null,
                'phone'         => '(877) 639-0563',
                'email'         => null,
                'street'        => null,
                'street2'       => null,
                'city'          => null,
                'state_id'      => null,
                'zip'           => null,
                'country_id'    => 237,
            ],
            [
                'id'            => 5,
                'name'          => 'Horizontal Talent',
                'slug'          => 'horizontal-talent',
                'postings_url'  => 'https://www.horizontaltalent.com/job-board',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'          => 'https://www.horizontaltalent.com/',
                'link_name'     => null,
                'phone'         => '(612) 392-7580',
                'email'         => null,
                'street'        => '1660 MN-100',
                'street2'       => 'Suite 200',
                'city'          => 'St. Louis',
                'state_id'      => 24,
                'zip'           => 55416,
                'country_id'    => 237,
            ],
            [
                'id'            => 6,
                'name'          => 'Ranstad USA',
                'slug'          => 'ranstad-usa',
                'postings_url'  => 'https://www.randstadusa.com/jobs/',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'          => 'https://www.randstadusa.com/',
                'link_name'     => null,
                'phone'         => '',
                'email'         => '',
                'street'        => 'One Overton Park',
                'street2'       => '3625 Cumberland Blvd SE',
                'city'          => 'Atlanta',
                'state_id'      => 11,
                'zip'           => 30339,
                'country_id'    => 237,
            ],
            [
                'id'            => 7,
                'name'          => 'CyberCoders',
                'slug'          => 'cybercoders',
                'postings_url'  => 'https://www.cybercoders.com/search',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'          => 'https://www.cybercoders.com/',
                'link_name'     => null,
                'phone'         => '',
                'email'         => '',
                'street'        => null,
                'street2'       => null,
                'city'          => null,
                'state_id'      => null,
                'zip'           => null,
                'country_id'    => 237,
            ],


            /*
            [
                'id'           => 8,
                'name'         => '',
                'slug'         => '',
                'postings_url' => '',
                'local'         => 0,
                'regional'      => 0,
                'national'      => 1,
                'international' => 0,
                'link'         => '',
                'link_name'    => null,
                'phone'        => '',
                'email'        => '',
                'street'       => null,
                'street2'      => null,
                'city'         => null,
                'state_id'     => null,
                'zip'          => null,
                'country_id'   => 237,
            ],
            */
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['public'] = 1;
            $data[$i]['root'] = 1;
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Recruiter::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('recruiters');
    }
};
