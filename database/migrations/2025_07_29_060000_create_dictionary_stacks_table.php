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
        Schema::connection('dictionary_db')->create('stacks', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('website')->nullable();
            $table->string('wiki_page')->nullable();
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1,  'name' => 'BCH',           'full_name' => 'BCH',           'slug' => 'bch',           'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 2,  'name' => 'ELK',           'full_name' => 'ELK',           'slug' => 'elk',           'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 3,  'name' => 'Ganeti',        'full_name' => 'Ganeti',        'slug' => 'ganeti',        'website' => '',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/Ganeti' ],
            [ 'id' => 4,  'name' => 'GRANDstack',    'full_name' => 'GRANDstack',    'slug' => 'grandstack',    'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 5,  'name' => 'GLASS',         'full_name' => 'GLASS',         'slug' => 'glass',         'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 6,  'name' => 'JAMstack',      'full_name' => 'JAMstack',      'slug' => 'jamstack',      'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 7,  'name' => 'Java-Spring',   'full_name' => 'Java-Spring',   'slug' => 'java-spring',   'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 8,  'name' => 'LAMP',          'full_name' => 'LAMP',          'slug' => 'lamp',          'website' => null,                                      'wiki_page' => 'https://en.wikipedia.org/wiki/LAMP_(software_bundle)' ],
            [ 'id' => 9,  'name' => 'LAPP',          'full_name' => 'LAPP',          'slug' => 'lapp',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 10, 'name' => 'LEAP',          'full_name' => 'LEAP',          'slug' => 'leap',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 11, 'name' => 'LEMP',          'full_name' => 'LEMP',          'slug' => 'lemp',          'website' => 'https://www.digitalocean.com/community/tutorials/what-is-lemp', 'wiki_page' => null ],
            [ 'id' => 12, 'name' => 'LLMP',          'full_name' => 'LLMP',          'slug' => 'llmp',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 13, 'name' => 'LNMP',          'full_name' => 'LNMP',          'slug' => 'lnmp',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 14, 'name' => 'LYCE',          'full_name' => 'LYCE',          'slug' => 'lyce',          'website' => '',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/LYME_(software_bundle)' ],
            [ 'id' => 15, 'name' => 'LYME',          'full_name' => 'LYME',          'slug' => 'lyme',          'website' => '',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/LYME_(software_bundle)' ],
            [ 'id' => 16, 'name' => 'MAMP',          'full_name' => 'MAMP',          'slug' => 'mamp',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 17, 'name' => 'MARQS',         'full_name' => 'MARQS',         'slug' => 'marqs',         'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 18, 'name' => 'MEAN',          'full_name' => 'MEAN',          'slug' => 'mean',          'website' => 'https://www.mongodb.com/resources/languages/mean-stack', 'wiki_page' => 'https://en.wikipedia.org/wiki/JavaScript_stack#MEAN/MERN/MEVN' ],
            [ 'id' => 19, 'name' => 'MENG',          'full_name' => 'MENG',          'slug' => 'meng',          'website' => '',                                        'wiki_page' => '' ],
            [ 'id' => 20, 'name' => 'MERN',          'full_name' => 'MERN',          'slug' => 'mern',          'website' => 'https://www.mongodb.com/resources/languages/mern-stack', 'wiki_page' => 'https://en.wikipedia.org/wiki/JavaScript_stack#MEAN/MERN/MEVN' ],
            [ 'id' => 21, 'name' => 'MEVN',          'full_name' => 'MEVN',          'slug' => 'mevn',          'website' => null,                                      'wiki_page' => 'https://en.wikipedia.org/wiki/JavaScript_stack#MEAN/MERN/MEVN' ],
            [ 'id' => 22, 'name' => 'MLVN',          'full_name' => 'MLVN',          'slug' => 'mlvn',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 23, 'name' => 'NMP',           'full_name' => 'NMP',           'slug' => 'nmp',           'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 24, 'name' => 'OpenACS',       'full_name' => 'OpenACS',       'slug' => 'openacs',       'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 25, 'name' => 'PERN',          'full_name' => 'PERN',          'slug' => 'pern',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 26, 'name' => 'PLONK',         'full_name' => 'PLONK',         'slug' => 'plonk',         'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 27, 'name' => 'Python-Django', 'full_name' => 'Python-Django', 'slug' => 'python-django', 'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 28, 'name' => 'Ruby on Rails', 'full_name' => 'Ruby on Rails', 'slug' => 'ruby-on-rails', 'website' => 'https://rubyonrails.org/',                'wiki_page' => 'https://en.wikipedia.org/wiki/Ruby_on_Rails' ],
            [ 'id' => 29, 'name' => 'SMACK',         'full_name' => 'SMACK',         'slug' => 'smack',         'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 30, 'name' => 'T-REx',         'full_name' => 'T-REx',         'slug' => 't-rex',         'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 31, 'name' => 'TALL',          'full_name' => 'TALL',          'slug' => 'tall',          'website' => 'https://tallstack.dev/',                  'wiki_page' => null ],
            [ 'id' => 32, 'name' => 'WAMP',          'full_name' => 'WAMP',          'slug' => 'wamp',          'website' => '',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/WampServer' ],
            [ 'id' => 33, 'name' => 'WIMP',          'full_name' => 'WIMP',          'slug' => 'wimp',          'website' => '',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/WIMP_(software_bundle)' ],
            [ 'id' => 34, 'name' => 'WINS',          'full_name' => 'WINS',          'slug' => 'wins',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 35, 'name' => 'WIPAV',         'full_name' => 'WIPAV',         'slug' => 'wipav',         'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 36, 'name' => 'WISA',          'full_name' => 'WISA',          'slug' => 'wisa',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 37, 'name' => 'WISAV',         'full_name' => 'WISAV',         'slug' => 'wsav',          'website' => '',                                        'wiki_page' => null ],
            [ 'id' => 38, 'name' => 'XAMPP',         'full_name' => 'XAMPP',         'slug' => 'xampp',         'website' => '',                                        'wiki_page' => 'https://en.wikipedia.org/wiki/XAMPP' ],
            [ 'id' => 39, 'name' => 'XRX',           'full_name' => 'XRX',           'slug' => 'xrx',           'website' => '',                                        'wiki_page' => null ],
        ];
        \App\Models\Dictionary\Stack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('stacks');
    }
};
