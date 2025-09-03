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
            $table->string('abbreviation', 20)->nullable();
            $table->tinyInteger('open_source')->default(0);
            $table->tinyInteger('proprietary')->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('wikipedia')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,   'full_name' => 'Apache HTTP Server',            'name' => 'Apache',         'slug' => 'apache-http-server',        'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://httpd.apache.org/',                                   'wikipedia' => 'https://en.wikipedia.org/wiki/Apache_HTTP_Server'            ],
            [ 'id' => 2,   'full_name' => 'Apache Tomcat',                 'name' => ' Tomcat',        'slug' => 'apache-tomcat',             'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://tomcat.apache.org/',                                  'wikipedia' => 'https://en.wikipedia.org/wiki/Apache_Tomcat'                 ],
            [ 'id' => 3,   'full_name' => 'AWS Fargate',                   'name' => 'Fargate',        'slug' => 'aws-fargate',               'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://aws.amazon.com/fargate/',                             'wikipedia' => null                                                          ],
            [ 'id' => 4,   'full_name' => 'Caddy',                         'name' => 'Caddy',          'slug' => 'caddy',                     'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://caddyserver.com/',                                    'wikipedia' => 'https://en.wikipedia.org/wiki/Caddy_(web_server)'            ],
            [ 'id' => 5,   'full_name' => 'Cherokee',                      'name' => 'Cherokee',       'slug' => 'cherokee',                  'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://cherokee-project.com/',                               'wikipedia' => 'https://en.wikipedia.org/wiki/Cherokee_(web_server)'         ],
            [ 'id' => 6,   'full_name' => 'Hiawatha',                      'name' => 'Hiawatha',       'slug' => 'hiawatha',                  'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://hiawatha.leisink.net/',                               'wikipedia' => 'https://en.wikipedia.org/wiki/Hiawatha_(web_server)'         ],
            [ 'id' => 7,   'full_name' => 'Internet Information Services', 'name' => 'Microsoft ISS',  'slug' => 'microsoft-iis',             'abbreviation' => 'IIS',  'open_source' => 0, 'proprietary' => 1, 'owner' => 'Microsoft', 'link' => 'https://www.iis.net/',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/Internet_Information_Services' ],
            [ 'id' => 8,   'full_name' => 'Jigsaw',                        'name' => 'Jigsaw',         'slug' => 'jigsaw',                    'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://www.w3.org/Jigsaw/',                                  'wikipedia' => null                                                          ],
            [ 'id' => 9,   'full_name' => 'LiteSpeed Web Server',          'name' => 'LiteSpeed',      'slug' => 'litespeed-web-server',      'abbreviation' => 'LSWS', 'open_source' => 0, 'proprietary' => 1, 'owner' => null,        'link' => 'https://docs.litespeedtech.com/lsws/',                        'wikipedia' => 'https://en.wikipedia.org/wiki/LiteSpeed_Web_Server'          ],
            [ 'id' => 10,  'full_name' => 'Lighttpd',                      'name' => 'Lighttpd',       'slug' => 'lighttpd',                  'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://www.lighttpd.net/',                                   'wikipedia' => 'https://en.wikipedia.org/wiki/Lighttpd'                      ],
            [ 'id' => 11,  'full_name' => 'Nginx',                         'name' => 'Nginx',          'slug' => 'nginx',                     'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://nginx.org/',                                          'wikipedia' => 'https://en.wikipedia.org/wiki/Nginx'                         ],
            [ 'id' => 12,  'full_name' => 'Node.js',                       'name' => 'Node.js',        'slug' => 'node-js',                   'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://nodejs.org/en',                                       'wikipedia' => 'https://en.wikipedia.org/wiki/Node.js'                       ],
            [ 'id' => 13,  'full_name' => 'OpenLiteSpeed',                 'name' => 'OpenLiteSpeed',  'slug' => 'openlitespeed',             'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'https://openlitespeed.org/',                                  'wikipedia' => null                                                          ],
            [ 'id' => 14,  'full_name' => 'Oracle iPlanet Web Server',     'name' => 'OiWS',           'slug' => 'oracle-iplanet-web-server', 'abbreviation' => 'OiWS', 'open_source' => 0, 'proprietary' => 0, 'owner' => 'Oracle',    'link' => 'https://docs.oracle.com/cd/E36784_01/html/E49624/gnvio.html', 'wikipedia' => 'https://en.wikipedia.org/wiki/Oracle_iPlanet_Web_Server'     ],
            [ 'id' => 15,  'full_name' => 'Roxen',                         'name' => 'Roxen',          'slug' => 'roxen',                     'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null,        'link' => 'http://download.roxen.com/cgi-sys/defaultwebpage.cgi',        'wikipedia' => 'https://en.wikipedia.org/wiki/Roxen_(web_server)'            ],
            [ 'id' => 16,  'full_name' => 'Windows Server',                'name' => 'Windows Server', 'slug' => 'windows-server',            'abbreviation' => null,   'open_source' => 0, 'proprietary' => 1, 'owner' => 'Microsoft', 'link' => 'https://www.microsoft.com/en-us/windows-server',              'wikipedia' => 'https://en.wikipedia.org/wiki/Windows_Server'                ],
            [ 'id' => 17,  'full_name' => 'other',                         'name' => 'other',          'slug' => 'other',                     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => null,                                                          'wikipedia' => null                                                          ],
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
