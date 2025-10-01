<?php

use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
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
        Schema::connection($this->database_tag)->create('company_contact', function (Blueprint $table) {
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('active')->default(1);
            $table->primary(['company_id', 'contact_id']);
            $table->timestamps();
        });

        $data = [
            [ 'company_id' => 1,  'contact_id' => 1,  'active' => 1 ],
            [ 'company_id' => 2,  'contact_id' => 2,  'active' => 1 ],
            [ 'company_id' => 4,  'contact_id' => 3,  'active' => 1 ],
            [ 'company_id' => 6,  'contact_id' => 4,  'active' => 1 ],
            [ 'company_id' => 7,  'contact_id' => 5,  'active' => 1 ],
            [ 'company_id' => 8,  'contact_id' => 6,  'active' => 1 ],
            [ 'company_id' => 9,  'contact_id' => 10, 'active' => 1 ],
            [ 'company_id' => 9,  'contact_id' => 11, 'active' => 1 ],
            [ 'company_id' => 9,  'contact_id' => 12, 'active' => 1 ],
            [ 'company_id' => 9,  'contact_id' => 13, 'active' => 1 ],
            [ 'company_id' => 2,  'contact_id' => 14, 'active' => 1 ],
            [ 'company_id' => 12, 'contact_id' => 16, 'active' => 1 ],
            [ 'company_id' => 13, 'contact_id' => 17, 'active' => 1 ],
            [ 'company_id' => 14, 'contact_id' => 8,  'active' => 1 ],
            [ 'company_id' => 15, 'contact_id' => 19, 'active' => 1 ],
            [ 'company_id' => 21, 'contact_id' => 20, 'active' => 1 ],
            [ 'company_id' => 22, 'contact_id' => 21, 'active' => 1 ],
            [ 'company_id' => 23, 'contact_id' => 23, 'active' => 1 ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        CompanyContact::insert($data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('company_contact');
    }
};
