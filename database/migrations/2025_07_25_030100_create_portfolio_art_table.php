<?php

use App\Models\Admin;
use App\Models\Portfolio\Art;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * The id of the admin who owns the portfolio art resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('art', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('artist')->nullable();
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->year('year')->nullable();
            $table->string('image_url', 500)->nullable();
            $table->text('notes')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');

            $table->index('name');
            $table->index('artist');
        });


        $data = [
            [
                'id'             => 1,
                'name'           => 'former painting from Cat\'s Cradle',
                'artist'         => 'Laird Dixon',
                'slug'           => 'former-painting-from-cats-cradle-by-laird-dixon',
                'featured'       => 1,
                'summary'        => null,
                'year'           => 1992,
                'image_url'      => 'https://previews.dropbox.com/p/thumb/ACygnBaiFphCEFohhNuV35KzY7Fh4-vi3dqZuV1st1a0Sa4mG07-pTU4cC3UUi8o0XKRmlj5hVcxw2zdJEPThvRRe_F0lsr2x21bIiRZJKbGpOOjRCd06N4wDBGDWW0kkgxLsQz5gc7BvA4_Z5t1PpSit4Js-4Zk_WBcg3vPNcU9mZKEwAv8K6pnRuGx_hkbTNdmZeuyZuqKRMCtJsDoX9SHVLKX6UYUx_pAjD6HPUbg6GgRGxXGZDteRrK4eBmI33Wj3nttYHDTarEFQDszMOdADI18A-quMdhV0yetlQyJt-Yn60gnx27ltmyBJkGi9Y9kgHezE3x3y8i8OwUGX09x/p.png?is_prewarmed=true',
                'notes'          => null,
                'description'    => '',
                'public'         => 1,
            ],
            [
                'id'             => 2,
                'name'           => 'Sleazefest! cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-cover-art-devlin-thompson',
                'featured'       => 1,
                'summary'        => null,
                'year'           => 1994,
                'image_url'      => 'https://previews.dropbox.com/p/thumb/ACzQo_zV6sefn5roUiYMZCWZb__zRxKL2WfH8bMwSVyhBUb6gqt6yuh_zXRVh2hpcNs-ytNPFKw-9VQUko9CD1bMQ6bljn0ZRn50Uhl2eLonTLtiYYHraI4ff_teDzBSzW0Sfo8AubGZRzOIDZ24B-1hPBvRuH47ivohXuHHo5HnxFJmjuCUTfEvBR4ho9rQFFU-z1KXM-d6PGTjpAc4Vhf-Pno2BI3oWDYJRCAiuZCwA-DefXQJXdCgEqRjk4rwBhjAz82xZPnzno8KoPT16gf9Xyg7O8sa-IcX7uM7nOkBrz0bi5TqPEs_Z5E6O4YS-cQklT2aeT7aLP0riRZE49Q9/p.jpeg?is_prewarmed=true',
                'notes'          => null,
                'description'    => '',
                'public'         => 1,
            ],
            [
                'id'             => 3,
                'name'           => 'Sleazefest! back cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-back-cover-art-devlin-thompson',
                'featured'       => 0,
                'summary'        => null,
                'year'           => 1994,
                'image_url'      => 'https://previews.dropbox.com/p/thumb/ACzyF6XVUlSO34Gch4u4A87fFRlqwCN0Xr2P6O2JjBhkqqpTeB-xafXqzg4YsjLmNOOK9HJ1LVtg6t9Tbi6TtKZ_MJ2s8wInefNHuDzWpeMMuXGoi2N04hXgG8CeDKgYUtSI9wTSROtuEuDj3xQR7mRPtIsdn2A07qpOycqoH5iZ98tSIed8YOnKOYr3jNO2s22DY2whkjNf09qQikJZoefk92viuf_rTCn2PS8KiX0_OGwjUzo8qhOj6Y6dfzWHR6YRqHbpkeKC-yJDl86dPmf7Jcuz8S67ep4D2NOOGKTIfzpyFlKZaP_2dCIPZNAvvtY/p.png',
                'notes'          => null,
                'description'    => '',
                'public'         => 1,
            ],
            [
                'id'             => 4,
                'name'           => 'Sleazefest! VHS cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-vhs-cover-art-devlin-thompson',
                'featured'       => 1,
                'summary'        => null,
                'year'           => 1994,
                'image_url'      => 'https://previews.dropbox.com/p/thumb/ACzQo_zV6sefn5roUiYMZCWZb__zRxKL2WfH8bMwSVyhBUb6gqt6yuh_zXRVh2hpcNs-ytNPFKw-9VQUko9CD1bMQ6bljn0ZRn50Uhl2eLonTLtiYYHraI4ff_teDzBSzW0Sfo8AubGZRzOIDZ24B-1hPBvRuH47ivohXuHHo5HnxFJmjuCUTfEvBR4ho9rQFFU-z1KXM-d6PGTjpAc4Vhf-Pno2BI3oWDYJRCAiuZCwA-DefXQJXdCgEqRjk4rwBhjAz82xZPnzno8KoPT16gf9Xyg7O8sa-IcX7uM7nOkBrz0bi5TqPEs_Z5E6O4YS-cQklT2aeT7aLP0riRZE49Q9/p.jpeg?is_prewarmed=true',
                'notes'          => null,
                'description'    => '',
                'public'         => 1,
            ],
            [
                'id'             => 5,
                'name'           => 'Sleazefest! VHS back cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-vhs-back-cover-art-devlin-thompson',
                'featured'       => 0,
                'summary'        => null,
                'year'           => 1994,
                'image_url'      => 'https://previews.dropbox.com/p/thumb/ACzefzZk9ckCnCKMjN7gcH5wKdmAWVdEZlCyarmAQGkFNvEx0i-56udCzC1LNRxDRIVWXDpeyfu_b8pODnOVTGZMxIyEHF2X-PQZ76OsFedkGFHOX4pKx2kmHd3lpj-cfgd_kNEQxYKIboYajLP0TS1-Z0vvF6OuGbQQdM40xaxkxBdKDokdfDZc7xlyUA5qx9F0zlseZaMXBTv6YxM4ovjC2DYw3CLsEoMZSnaOkV77YOgG2nx8ZRxchleRJcGU-PN2NtAnmW89jruvZpUgyV5oUC44HKacBukhtbsp-iZ5AjOVuy1BzeZRe0PPudm22A0p48CXuYMfDlOr8Sx1ciTb/p.jpeg?is_prewarmed=true',
                'notes'          => null,
                'description'    => '',
                'public'         => 1,
            ],


            /*
            [
                'id'             => 1,
                'name'           => '',
                'artist'         => '',
                'slug'           => '',
                'featured'       => 0,
                'summary'        => null,
                'year'           => null,
                'image_url'      => '',
                'notes'          => null,
                'description'    => '',
                'public'         => 1,
            ],
            */
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Art::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('art');
    }
};
