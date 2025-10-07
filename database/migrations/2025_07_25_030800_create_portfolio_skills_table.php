<?php

use App\Models\Portfolio\Skill;
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
     * The id of the admin who owns the portfolio skill resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->string('name');
            $table->string('version', 20)->nullable();
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->tinyInteger('level')->default(1);
            $table->foreignIdFor(\App\Models\Dictionary\Category::class, 'category_id');
            $table->integer('start_year')->nullable();
            $table->integer('years')->default(0);
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
        });

        $data = [
            [ 'id' => 1,  'name' => 'Laravel',           'version' => '12', 'category_id' => 11,  'featured' => 1, 'level' => 10, 'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 2,  'name' => 'CodeIgniter',       'version' => '4',  'category_id' => 11,  'featured' => 1, 'level' => 10, 'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 3,  'name' => 'CakePHP',           'version' => null, 'category_id' => 11,  'featured' => 0, 'level' => 3,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 4,  'name' => 'Symfony',           'version' => null, 'category_id' => 11,  'featured' => 0, 'level' => 1,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 5,  'name' => 'Vue.js',            'version' => null, 'category_id' => 11,  'featured' => 1, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 6,  'name' => 'jQuery',            'version' => null, 'category_id' => 11,  'featured' => 0, 'level' => 10, 'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 7,  'name' => 'React',             'version' => null, 'category_id' => 11,  'featured' => 0, 'level' => 3,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 8,  'name' => 'JavaScript',        'version' => null, 'category_id' => 12,  'featured' => 1, 'level' => 9,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 9,  'name' => 'PHP',               'version' => null, 'category_id' => 12,  'featured' => 1, 'level' => 10, 'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 10, 'name' => 'SQL',               'version' => null, 'category_id' => 12,  'featured' => 1, 'level' => 9,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 11, 'name' => 'Powershell',        'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 3,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 12, 'name' => 'BASH',              'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 6,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 13, 'name' => 'DOS',               'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 6,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 14, 'name' => 'MySQL',             'version' => null, 'category_id' => 8,   'featured' => 1, 'level' => 9,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 15, 'name' => 'MariaDB',           'version' => null, 'category_id' => 8,   'featured' => 1, 'level' => 9,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 16, 'name' => 'Postgres',          'version' => null, 'category_id' => 8,   'featured' => 1, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 17, 'name' => 'MongoDB',           'version' => null, 'category_id' => 8,   'featured' => 0, 'level' => 3,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 18, 'name' => 'Elasticsearch',     'version' => null, 'category_id' => 8,   'featured' => 0, 'level' => 3,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 19, 'name' => 'Linux',             'version' => null, 'category_id' => 17,  'featured' => 1, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 20, 'name' => 'Ubuntu',            'version' => null, 'category_id' => 17,  'featured' => 1, 'level' => 7,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 21, 'name' => 'Windows',           'version' => null, 'category_id' => 17,  'featured' => 1, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 22, 'name' => 'macOS',             'version' => null, 'category_id' => 17,  'featured' => 0, 'level' => 4,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 23, 'name' => 'Apache2',           'version' => null, 'category_id' => 26,  'featured' => 0, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 24, 'name' => 'Nginx',             'version' => null, 'category_id' => 26,  'featured' => 0, 'level' => 7,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 25, 'name' => 'Git',               'version' => null, 'category_id' => 34,  'featured' => 0, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 26, 'name' => 'JIRA',              'version' => null, 'category_id' => 34,  'featured' => 0, 'level' => 7,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 27, 'name' => 'HTML5',             'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 28, 'name' => 'CSS3',              'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 29, 'name' => 'DOM',               'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 10, 'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 30, 'name' => 'JSX',               'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 31, 'name' => 'Ajax',              'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 8,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 32, 'name' => 'Twitter Bootstrap', 'version' => null, 'category_id' => 11,  'featured' => 0, 'level' => 7,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 33, 'name' => 'Bulma',             'version' => null, 'category_id' => 11,  'featured' => 0, 'level' => 4,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 34, 'name' => 'JSON',              'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 10, 'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 35, 'name' => 'REST',              'version' => null, 'category_id' => 16,  'featured' => 0, 'level' => 9,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 36, 'name' => 'XML',               'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 7,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 37, 'name' => 'RDF',               'version' => null, 'category_id' => 12,  'featured' => 0, 'level' => 7,  'years' => 20, 'start_year' => null, 'public' => 1 ],
            [ 'id' => 38, 'name' => 'Docker',            'version' => null, 'category_id' => 19,  'featured' => 0, 'level' => 4,  'years' => 20, 'start_year' => null, 'public' => 1 ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Skill::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('skills');
    }
};
