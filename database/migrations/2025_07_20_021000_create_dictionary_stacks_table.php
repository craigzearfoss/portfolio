<?php

use App\Models\Dictionary\Stack;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('stacks', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->string('definition')->nullable();
            $table->tinyInteger('open_source')->default(0);
            $table->tinyInteger('proprietary')->default(0);
            $table->tinyInteger('compiled')->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('wikipedia', 500)->nullable();
            $table->string('link', 500)->nullable();
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
        });

        $data = [
            [ 'id' => 2,  'full_name' => 'ELK',           'name' => 'ELK',           'slug' => 'elk',           'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 3,  'full_name' => 'Ganeti',        'name' => 'Ganeti',        'slug' => 'ganeti',        'abbreviation' => null,    'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/Ganeti',                                         'definition' => '' ],
            [ 'id' => 4,  'full_name' => 'GRANDstack',    'name' => 'GRANDstack',    'slug' => 'grandstack',    'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 5,  'full_name' => 'GLASS',         'name' => 'GLASS',         'slug' => 'glass',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 6,  'full_name' => 'JAMstack',      'name' => 'JAMstack',      'slug' => 'jamstack',      'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 7,  'full_name' => 'Java-Spring',   'name' => 'Java-Spring',   'slug' => 'java-spring',   'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 8,  'full_name' => 'LAMP',          'name' => 'LAMP',          'slug' => 'lamp',          'abbreviation' => 'LAMP',  'link' => null,                                      'wikipedia' => 'https://en.wikipedia.org/wiki/LAMP_(software_bundle)',                         'definition' => '' ],
            [ 'id' => 9,  'full_name' => 'LAPP',          'name' => 'LAPP',          'slug' => 'lapp',          'abbreviation' => 'LAPP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 10, 'full_name' => 'LEAP',          'name' => 'LEAP',          'slug' => 'leap',          'abbreviation' => 'LEAP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 11, 'full_name' => 'LEMP',          'name' => 'LEMP',          'slug' => 'lemp',          'abbreviation' => 'LEMP',  'link' => 'https://www.digitalocean.com/community/tutorials/what-is-lemp', 'wikipedia' => null,                                                     'definition' => '' ],
            [ 'id' => 12, 'full_name' => 'LLMP',          'name' => 'LLMP',          'slug' => 'llmp',          'abbreviation' => 'LLMP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 13, 'full_name' => 'LNMP',          'name' => 'LNMP',          'slug' => 'lnmp',          'abbreviation' => 'LNMP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 14, 'full_name' => 'LYCE',          'name' => 'LYCE',          'slug' => 'lyce',          'abbreviation' => 'LYCE',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/LYME_(software_bundle)',                         'definition' => '' ],
            [ 'id' => 15, 'full_name' => 'LYME',          'name' => 'LYME',          'slug' => 'lyme',          'abbreviation' => 'LYME',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/LYME_(software_bundle)',                         'definition' => '' ],
            [ 'id' => 16, 'full_name' => 'MAMP',          'name' => 'MAMP',          'slug' => 'mamp',          'abbreviation' => 'MAMP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 17, 'full_name' => 'MARQS',         'name' => 'MARQS',         'slug' => 'marqs',         'abbreviation' => 'MARQS', 'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 18, 'full_name' => 'MEAN',          'name' => 'MEAN',          'slug' => 'mean',          'abbreviation' => 'MEAN',  'link' => 'https://www.mongodb.com/resources/languages/mean-stack', 'wikipedia' => 'https://en.wikipedia.org/wiki/JavaScript_stack#MEAN/MERN/MEVN', 'definition' => '' ],
            [ 'id' => 19, 'full_name' => 'MENG',          'name' => 'MENG',          'slug' => 'meng',          'abbreviation' => 'MENG',  'link' => '',                                        'wikipedia' => '',                                                                             'definition' => '' ],
            [ 'id' => 20, 'full_name' => 'MERN',          'name' => 'MERN',          'slug' => 'mern',          'abbreviation' => 'MERN',  'link' => 'https://www.mongodb.com/resources/languages/mern-stack', 'wikipedia' => 'https://en.wikipedia.org/wiki/JavaScript_stack#MEAN/MERN/MEVN', 'definition' => '' ],
            [ 'id' => 21, 'full_name' => 'MEVN',          'name' => 'MEVN',          'slug' => 'mevn',          'abbreviation' => 'MEVN',  'link' => null,                                      'wikipedia' => 'https://en.wikipedia.org/wiki/JavaScript_stack#MEAN/MERN/MEVN',                'definition' => '' ],
            [ 'id' => 22, 'full_name' => 'MLVN',          'name' => 'MLVN',          'slug' => 'mlvn',          'abbreviation' => 'MLVN',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 23, 'full_name' => 'NMP',           'name' => 'NMP',           'slug' => 'nmp',           'abbreviation' => 'NMP',   'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 24, 'full_name' => 'OpenACS',       'name' => 'OpenACS',       'slug' => 'openacs',       'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 25, 'full_name' => 'PERN',          'name' => 'PERN',          'slug' => 'pern',          'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 26, 'full_name' => 'PLONK',         'name' => 'PLONK',         'slug' => 'plonk',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 27, 'full_name' => 'Python-Django', 'name' => 'Python-Django', 'slug' => 'python-django', 'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 28, 'full_name' => 'Ruby on Rails', 'name' => 'Ruby on Rails', 'slug' => 'ruby-on-rails', 'abbreviation' => null,    'link' => 'https://rubyonrails.org/',                'wikipedia' => 'https://en.wikipedia.org/wiki/Ruby_on_Rails',                                  'definition' => '' ],
            [ 'id' => 29, 'full_name' => 'SMACK',         'name' => 'SMACK',         'slug' => 'smack',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 30, 'full_name' => 'T-REx',         'name' => 'T-REx',         'slug' => 't-rex',         'abbreviation' => 'T-REx', 'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 31, 'full_name' => 'TALL',          'name' => 'TALL',          'slug' => 'tall',          'abbreviation' => 'TALL',  'link' => 'https://tallstack.dev/',                  'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 32, 'full_name' => 'WAMP',          'name' => 'WAMP',          'slug' => 'wamp',          'abbreviation' => 'WAMP',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/WampServer',                                     'definition' => '' ],
            [ 'id' => 33, 'full_name' => 'WIMP',          'name' => 'WIMP',          'slug' => 'wimp',          'abbreviation' => 'WIMP',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/WIMP_(software_bundle)',                         'definition' => '' ],
            [ 'id' => 34, 'full_name' => 'WINS',          'name' => 'WINS',          'slug' => 'wins',          'abbreviation' => 'WINS',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 35, 'full_name' => 'WIPAV',         'name' => 'WIPAV',         'slug' => 'wipav',         'abbreviation' => 'WIPAV', 'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 36, 'full_name' => 'WISA',          'name' => 'WISA',          'slug' => 'wisa',          'abbreviation' => 'WISA',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 37, 'full_name' => 'WISAV',         'name' => 'WISAV',         'slug' => 'wsav',          'abbreviation' => 'WSAV',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 38, 'full_name' => 'XAMPP',         'name' => 'XAMPP',         'slug' => 'xampp',         'abbreviation' => 'XAMPP', 'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/XAMPP',                                          'definition' => '' ],
            [ 'id' => 39, 'full_name' => 'XRX',           'name' => 'XRX',           'slug' => 'xrx',           'abbreviation' => 'XRX',   'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 40, 'full_name' => 'other',         'name' => 'other',         'slug' => 'other',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Stack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('stacks');
    }
};
