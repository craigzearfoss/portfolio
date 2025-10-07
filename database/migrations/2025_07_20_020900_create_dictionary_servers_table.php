<?php

use App\Models\Dictionary\Server;
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
        Schema::connection($this->database_tag)->create('servers', function (Blueprint $table) {
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
            [ 'id' => 1,   'full_name' => 'Apache HTTP Server',            'name' => 'Apache',         'slug' => 'apache-http-server',        'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://httpd.apache.org/',                                   'wikipedia' => 'https://en.wikipedia.org/wiki/Apache_HTTP_Server',            'definition' => 'A free and open-source cross-platform web server, released under the terms of Apache License 2.0.' ],
            [ 'id' => 2,   'full_name' => 'Apache Tomcat',                 'name' => 'Tomcat',         'slug' => 'apache-tomcat',             'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://tomcat.apache.org/',                                  'wikipedia' => 'https://en.wikipedia.org/wiki/Apache_Tomcat',                 'definition' => 'A free and open-source implementation of the Jakarta Servlet, Jakarta Expression Language, and WebSocket technologies.' ],
            [ 'id' => 3,   'full_name' => 'AWS Fargate',                   'name' => 'Fargate',        'slug' => 'aws-fargate',               'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://aws.amazon.com/fargate/',                             'wikipedia' => null,                                                          'definition' => 'A serverless, pay-as-you-go compute engine that lets you focus on building applications without managing servers.' ],
            [ 'id' => 4,   'full_name' => 'Caddy',                         'name' => 'Caddy',          'slug' => 'caddy',                     'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://caddyserver.com/',                                    'wikipedia' => 'https://en.wikipedia.org/wiki/Caddy_(web_server)',            'definition' => 'An extensible, cross-platform, open-source web server written in Go.' ],
            [ 'id' => 5,   'full_name' => 'Cherokee',                      'name' => 'Cherokee',       'slug' => 'cherokee',                  'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://cherokee-project.com/',                               'wikipedia' => 'https://en.wikipedia.org/wiki/Cherokee_(web_server)',         'definition' => 'An open-source cross-platform web server that runs on Linux, BSD variants, Solaris, OS X, and Windows.' ],
            [ 'id' => 6,   'full_name' => 'Hiawatha',                      'name' => 'Hiawatha',       'slug' => 'hiawatha',                  'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://hiawatha.leisink.net/',                               'wikipedia' => 'https://en.wikipedia.org/wiki/Hiawatha_(web_server)',         'definition' => 'A free and open source cross-platform web server developed by Hugo Leisink.' ],
            [ 'id' => 7,   'full_name' => 'Internet Information Services', 'name' => 'Microsoft ISS',  'slug' => 'microsoft-iis',             'abbreviation' => 'IIS',  'open_source' => 0, 'proprietary' => 1, 'owner' => 'Microsoft', 'link' => 'https://www.iis.net/',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/Internet_Information_Services', 'definition' => 'An extensible web server created by Microsoft for use with the Windows NT family.' ],
            [ 'id' => 8,   'full_name' => 'Jigsaw',                        'name' => 'Jigsaw',         'slug' => 'jigsaw',                    'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://www.w3.org/Jigsaw/',                                  'wikipedia' => null,                                                          'definition' => 'A web server platform, providing a sample HTTP 1.1 implementation and a variety of other features on top of an advanced architecture implemented in Java.' ],
            [ 'id' => 9,   'full_name' => 'LiteSpeed Web Server',          'name' => 'LiteSpeed',      'slug' => 'litespeed-web-server',      'abbreviation' => 'LSWS', 'open_source' => 0, 'proprietary' => 1, 'owner' => null,        'link' => 'https://docs.litespeedtech.com/lsws/',                        'wikipedia' => 'https://en.wikipedia.org/wiki/LiteSpeed_Web_Server',          'definition' => 'A high performance, secure, easy-to-use web server, and can be used as a drop-in replacement for an Apache web server.' ],
            [ 'id' => 10,  'full_name' => 'Lighttpd',                      'name' => 'Lighttpd',       'slug' => 'lighttpd',                  'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://www.lighttpd.net/',                                   'wikipedia' => 'https://en.wikipedia.org/wiki/Lighttpd',                      'definition' => 'An open-source web server optimized for speed-critical environments while remaining standards-compliant, secure and flexible.' ],
            [ 'id' => 11,  'full_name' => 'Nginx',                         'name' => 'Nginx',          'slug' => 'nginx',                     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://nginx.org/',                                          'wikipedia' => 'https://en.wikipedia.org/wiki/Nginx',                         'definition' => 'A web server that can also be used as a reverse proxy, load balancer, mail proxy and HTTP cache.' ],
            [ 'id' => 12,  'full_name' => 'Node.js',                       'name' => 'Node.js',        'slug' => 'node-js',                   'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://nodejs.org/en',                                       'wikipedia' => 'https://en.wikipedia.org/wiki/Node.js',                       'definition' => 'A cross-platform, open-source JavaScript runtime environment that can run on Windows, Linux, Unix, macOS, and more.' ],
            [ 'id' => 13,  'full_name' => 'OpenLiteSpeed',                 'name' => 'OpenLiteSpeed',  'slug' => 'openlitespeed',             'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://openlitespeed.org/',                                  'wikipedia' => null,                                                          'definition' => 'A high-performance, lightweight, open source HTTP server developed and copyrighted by LiteSpeed Technologies.' ],
            [ 'id' => 14,  'full_name' => 'Oracle iPlanet Web Server',     'name' => 'OiWS',           'slug' => 'oracle-iplanet-web-server', 'abbreviation' => 'OiWS', 'open_source' => 0, 'proprietary' => 0, 'owner' => 'Oracle',    'link' => 'https://docs.oracle.com/cd/E36784_01/html/E49624/gnvio.html', 'wikipedia' => 'https://en.wikipedia.org/wiki/Oracle_iPlanet_Web_Server',     'definition' => 'A web server developed by Oracle designed for medium and large business applications.' ],
            [ 'id' => 15,  'full_name' => 'Roxen',                         'name' => 'Roxen',          'slug' => 'roxen',                     'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'http://download.roxen.com/cgi-sys/defaultwebpage.cgi',        'wikipedia' => 'https://en.wikipedia.org/wiki/Roxen_(web_server)',            'definition' => 'A free software web server produced by Roxen Internet Software, a company based in Linköping, Sweden.' ],
            [ 'id' => 16,  'full_name' => 'Windows Server',                'name' => 'Windows Server', 'slug' => 'windows-server',            'abbreviation' => null,   'open_source' => 0, 'proprietary' => 1, 'owner' => 'Microsoft', 'link' => 'https://www.microsoft.com/en-us/windows-server',              'wikipedia' => 'https://en.wikipedia.org/wiki/Windows_Server',                'definition' => 'A brand name for server-oriented releases of the Windows NT operating system (OS) that have been developed by Microsoft since 1993.' ],
            [ 'id' => 17,  'full_name' => 'other',                         'name' => 'other',          'slug' => 'other',                     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => null,                                                          'wikipedia' => null,                                                          'definition' => '' ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Server::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('servers');
    }
};
