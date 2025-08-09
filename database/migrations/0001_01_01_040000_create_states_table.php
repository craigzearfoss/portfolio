<?php

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
        Schema::create('States', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name', 50);
        });

        $data = [
            [ 'code' => 'AL', 'name' => 'Alabama' ],
            [ 'code' => 'AK', 'name' => 'Alaska' ],
            [ 'code' => 'AZ', 'name' => 'Arizona' ],
            [ 'code' => 'AR', 'name' => 'Arkansas' ],
            [ 'code' => 'CA', 'name' => 'California' ],
            [ 'code' => 'CO', 'name' => 'Colorado' ],
            [ 'code' => 'CT', 'name' => 'Connecticut' ],
            [ 'code' => 'DC', 'name' => 'District of Columbia' ],
            [ 'code' => 'DE', 'name' => 'Delaware' ],
            [ 'code' => 'FL', 'name' => 'Florida' ],
            [ 'code' => 'GA', 'name' => 'Georgia' ],
            [ 'code' => 'HI', 'name' => 'Hawaii' ],
            [ 'code' => 'IA', 'name' => 'Iowa' ],
            [ 'code' => 'ID', 'name' => 'Idaho' ],
            [ 'code' => 'IL', 'name' => 'Illinois' ],
            [ 'code' => 'IN', 'name' => 'Indiana' ],
            [ 'code' => 'KS', 'name' => 'Kansas' ],
            [ 'code' => 'KY', 'name' => 'Kentucky' ],
            [ 'code' => 'LA', 'name' => 'Louisiana' ],
            [ 'code' => 'ME', 'name' => 'Maine' ],
            [ 'code' => 'MD', 'name' => 'Maryland' ],
            [ 'code' => 'MA', 'name' => 'Massachusetts' ],
            [ 'code' => 'MI', 'name' => 'Michigan' ],
            [ 'code' => 'MN', 'name' => 'Minnesota' ],
            [ 'code' => 'MS', 'name' => 'Mississippi' ],
            [ 'code' => 'MT', 'name' => 'Montana' ],
            [ 'code' => 'NC', 'name' => 'North Carolina' ],
            [ 'code' => 'ND', 'name' => 'North Dakota' ],
            [ 'code' => 'NE', 'name' => 'Nebraska' ],
            [ 'code' => 'NV', 'name' => 'Nevada' ],
            [ 'code' => 'NJ', 'name' => 'New Jersey' ],
            [ 'code' => 'NM', 'name' => 'New Mexico' ],
            [ 'code' => 'NY', 'name' => 'New York' ],
            [ 'code' => 'OH', 'name' => 'Ohio' ],
            [ 'code' => 'OK', 'name' => 'Oklahoma' ],
            [ 'code' => 'OR', 'name' => 'Oregon' ],
            [ 'code' => 'PA', 'name' => 'Pennsylvania' ],
            [ 'code' => 'RI', 'name' => 'Rhode Island' ],
            [ 'code' => 'SC', 'name' => 'South Carolina' ],
            [ 'code' => 'SD', 'name' => 'South Dakota' ],
            [ 'code' => 'TN', 'name' => 'Tennessee' ],
            [ 'code' => 'TX', 'name' => 'Texas' ],
            [ 'code' => 'UT', 'name' => 'Utah' ],
            [ 'code' => 'VT', 'name' => 'Vermont' ],
            [ 'code' => 'WA', 'name' => 'Washington' ],
            [ 'code' => 'WI', 'name' => 'Wisconsin' ],
            [ 'code' => 'WY', 'name' => 'Wyoming' ],
        ];
        App\Models\State::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
