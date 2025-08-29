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
        Schema::connection('dictionary_db')->create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 100)->nullable();
            $table->tinyInteger('open_source')->default(0);
            $table->tinyInteger('proprietary')->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('wiki_page')->nullable();
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1,   'name' => 'Apache',         'full_name' => 'Apache HTTP Server',            'slug' => 'apache-http-server',        'abbreviation' => 'Apache', 'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://httpd.apache.org/',                                   'wiki_page' => 'https://en.wikipedia.org/wiki/Apache_HTTP_Server' ],
            [ 'id' => 2,   'name' => 'Tomcat',         'full_name' => 'Apache Tomcat',                 'slug' => 'apache-tomcat',             'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://tomcat.apache.org/',                                  'wiki_page' => 'https://en.wikipedia.org/wiki/Apache_Tomcat' ],
            [ 'id' => 3,   'name' => 'Fargate',        'full_name' => 'AWS Fargate',                   'slug' => 'aws-fargate',               'abbreviation' => null,     'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'website' => 'https://aws.amazon.com/fargate/',                             'wiki_page' => null ],
            [ 'id' => 4,   'name' => 'Caddy',          'full_name' => 'Caddy',                         'slug' => 'caddy',                     'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://caddyserver.com/',                                    'wiki_page' => 'https://en.wikipedia.org/wiki/Caddy_(web_server)' ],
            [ 'id' => 5,   'name' => 'Cherokee',       'full_name' => 'Cherokee',                      'slug' => 'cherokee',                  'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://cherokee-project.com/',                               'wiki_page' => 'https://en.wikipedia.org/wiki/Cherokee_(web_server)' ],
            [ 'id' => 6,   'name' => 'Hiawatha',       'full_name' => 'Hiawatha',                      'slug' => 'hiawatha',                  'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://hiawatha.leisink.net/',                               'wiki_page' => 'https://en.wikipedia.org/wiki/Hiawatha_(web_server)' ],
            [ 'id' => 7,   'name' => 'ISS',            'full_name' => 'Internet Information Services', 'slug' => 'microsoft-iis',             'abbreviation' => 'Microsoft IIS', 'open_source' => 0, 'proprietary' => 1, 'owner' => 'Microsoft', 'website' => 'https://www.iis.net/',                                 'wiki_page' => 'https://en.wikipedia.org/wiki/Internet_Information_Services' ],
            [ 'id' => 8,   'name' => 'Jigsaw',         'full_name' => 'Jigsaw',                        'slug' => 'jigsaw',                    'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://www.w3.org/Jigsaw/',                                  'wiki_page' => null ],
            [ 'id' => 9,   'name' => 'LiteSpeed',      'full_name' => 'LiteSpeed Web Server',          'slug' => 'litespeed-web-server',      'abbreviation' => 'LSWS',   'open_source' => 0, 'proprietary' => 1, 'owner' => null,        'website' => 'https://docs.litespeedtech.com/lsws/',                        'wiki_page' => 'https://en.wikipedia.org/wiki/LiteSpeed_Web_Server' ],
            [ 'id' => 10,  'name' => 'Lighttpd',       'full_name' => 'Lighttpd',                      'slug' => 'lighttpd',                  'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://www.lighttpd.net/',                                   'wiki_page' => 'https://en.wikipedia.org/wiki/Lighttpd' ],
            [ 'id' => 11,  'name' => 'Nginx',          'full_name' => 'Nginx',                         'slug' => 'nginx',                     'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://nginx.org/',                                          'wiki_page' => 'https://en.wikipedia.org/wiki/Nginx' ],
            [ 'id' => 12,  'name' => 'Node.js',        'full_name' => 'Node.js',                       'slug' => 'node-js',                   'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://nodejs.org/en',                                       'wiki_page' => 'https://en.wikipedia.org/wiki/Node.js' ],
            [ 'id' => 13,  'name' => 'OpenLiteSpeed',  'full_name' => 'OpenLiteSpeed',                 'slug' => 'openlitespeed',             'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'https://openlitespeed.org/',                                  'wiki_page' => null ],
            [ 'id' => 14,  'name' => 'OiWS',           'full_name' => 'Oracle iPlanet Web Server',     'slug' => 'oracle-iplanet-web-server', 'abbreviation' => 'OiWS',   'open_source' => 0, 'proprietary' => 0, 'owner' => 'Oracle',    'website' => 'https://docs.oracle.com/cd/E36784_01/html/E49624/gnvio.html', 'wiki_page' => 'https://en.wikipedia.org/wiki/Oracle_iPlanet_Web_Server' ],
            [ 'id' => 15,  'name' => 'Roxen',          'full_name' => 'Roxen',                         'slug' => 'roxen',                     'abbreviation' => null,     'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'website' => 'http://download.roxen.com/cgi-sys/defaultwebpage.cgi',        'wiki_page' => 'https://en.wikipedia.org/wiki/Roxen_(web_server)' ],
            [ 'id' => 16,  'name' => 'Windows Server', 'full_name' => 'Windows Server',                'slug' => 'windows-server',            'abbreviation' => null,     'open_source' => 0, 'proprietary' => 1, 'owner' => 'Microsoft', 'website' => 'https://www.microsoft.com/en-us/windows-server',              'wiki_page' => 'https://en.wikipedia.org/wiki/Windows_Server' ],
        ];
        \App\Models\Dictionary\Server::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('servers');
    }
};
