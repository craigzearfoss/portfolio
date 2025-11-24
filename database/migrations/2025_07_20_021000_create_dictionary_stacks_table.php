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
            $table->string('definition', 500)->nullable();
            $table->boolean('open_source')->default(false);
            $table->boolean('proprietary')->default(false);
            $table->boolean('compiled')->default(false);
            $table->string('owner', 100)->nullable();
            $table->string('wikipedia', 500)->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 2,  'full_name' => 'ELK',           'name' => 'ELK',           'slug' => 'elk',           'abbreviation' => 'ELK',   'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack of open-source products—Elasticsearch, Logstash, and Kibana—used for collecting, processing, and visualizing data, particularly logs. It is now referred to as "Elastic Stack".' ],
            [ 'id' => 3,  'full_name' => 'Ganeti',        'name' => 'Ganeti',        'slug' => 'ganeti',        'abbreviation' => null,    'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/Ganeti',                                         'definition' => 'A  virtual machine cluster management tool originally developed by Google.' ],
            [ 'id' => 4,  'full_name' => 'GRANDstack',    'name' => 'GRANDstack',    'slug' => 'grandstack',    'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'A full-stack framework for building applications with GraphQL, React, Apollo and the Neo4j Database.' ],
            [ 'id' => 5,  'full_name' => 'GLASS',         'name' => 'GLASS',         'slug' => 'glass',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-level stack that includes GemStone (database and application server), Linux (operating system), Apache (web server), Smalltalk (programming language), and Seaside (web framework)' ],
            [ 'id' => 6,  'full_name' => 'JAMstack',      'name' => 'JAMstack',      'slug' => 'jamstack',      'abbreviation' => null,    'link' => 'https://jamstack.org/',                   'wikipedia' => 'https://en.wikipedia.org/wiki/JAMstack',                                       'definition' => 'A modern web development architecture based on JavaScript, APIs, and Markup.' ],
            [ 'id' => 7,  'full_name' => 'Spring',        'name' => 'Spring',        'slug' => 'java-spring',   'abbreviation' => null,    'link' => 'https://spring.io/',                      'wikipedia' => 'https://en.wikipedia.org/wiki/Spring_Framework',                               'definition' => 'An application framework and inversion of control container for the Java platform.' ],
            [ 'id' => 8,  'full_name' => 'LAMP',          'name' => 'LAMP',          'slug' => 'lamp',          'abbreviation' => 'LAMP',  'link' => null,                                      'wikipedia' => 'https://en.wikipedia.org/wiki/LAMP_(software_bundle)',                         'definition' => 'A generic software stack model has largely interchangeable components.' ],
            [ 'id' => 9,  'full_name' => 'LAPP',          'name' => 'LAPP',          'slug' => 'lapp',          'abbreviation' => 'LAPP',  'link' => 'https://www.woktron.com/secure/knowledgebase/144/-LAPP---Web-Stack-PostgreSQL.html', 'wikipedia' => null,                                'definition' => 'A variation of the LAMP stack where MySql is replaced with PostgreSQL.' ],
            [ 'id' => 10, 'full_name' => 'LEAP',          'name' => 'LEAP',          'slug' => 'leap',          'abbreviation' => 'LEAP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'Builds full-stack applications with real infrastructure and deploys them to your AWS or GCP cloud.' ],
            [ 'id' => 11, 'full_name' => 'LEMP',          'name' => 'LEMP',          'slug' => 'lemp',          'abbreviation' => 'LEMP',  'link' => 'https://www.digitalocean.com/community/tutorials/what-is-lemp', 'wikipedia' => null,                                                     'definition' => 'A variation of the LAMP stack that includes Linux (operating system), Nginx (web server), MySQL or MariaDB (database management systems), and Perl, PHP, or Python (scripting languages). Also known as LNMP.' ],
            [ 'id' => 12, 'full_name' => 'LLMP',          'name' => 'LLMP',          'slug' => 'llmp',          'abbreviation' => 'LLMP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'A variation of the LAMP stack that includes Linux (operating system), Lighttpd (web server), MySQL or MariaDB (database management systems), and Perl, PHP, or Python (scripting languages).' ],
            [ 'id' => 13, 'full_name' => 'LNMP',          'name' => 'LNMP',          'slug' => 'lnmp',          'abbreviation' => 'LNMP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'A variation of the LAMP stack that includes Linux (operating system), Nginx (web server), MySQL or MariaDB (database management systems), and Perl, PHP, or Python (scripting languages). Also known as LEMP.' ],
            [ 'id' => 14, 'full_name' => 'LYCE',          'name' => 'LYCE',          'slug' => 'lyce',          'abbreviation' => 'LYCE',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/LYME_(software_bundle)',                         'definition' => 'A software stack composed entirely of free and open-source software to build high-availability heavy duty dynamic web pages.' ],
            [ 'id' => 15, 'full_name' => 'LYME',          'name' => 'LYME',          'slug' => 'lyme',          'abbreviation' => 'LYME',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/LYME_(software_bundle)',                         'definition' => 'A software stack composed entirely of free and open-source software to build high-availability heavy duty dynamic web pages.' ],
            [ 'id' => 16, 'full_name' => 'MAMP',          'name' => 'MAMP',          'slug' => 'mamp',          'abbreviation' => 'MAMP',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'A variation of the LAMP stack that includes Mac OS X (operating system), Apache (web server), MySQL or MariaDB (database), and PHP, Perl, or Python (programming languages)' ],
            [ 'id' => 17, 'full_name' => 'MARQS',         'name' => 'MARQS',         'slug' => 'marqs',         'abbreviation' => 'MARQS', 'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stacks that includes Apache Mesos (node startup/shutdown), Akka (toolkit) (actor implementation), Riak (data store), Apache Kafka (messaging), Apache Spark (big data and MapReduce).' ],
            [ 'id' => 18, 'full_name' => 'MEAN',          'name' => 'MEAN',          'slug' => 'mean',          'abbreviation' => 'MEAN',  'link' => 'https://www.mongodb.com/resources/languages/mean-stack', 'wikipedia' => 'https://en.wikipedia.org/wiki/MEAN_(solution_stack)',           'definition' => 'A OS-level source-available JavaScript software stack for building dynamic web sites and web applications.' ],
            [ 'id' => 19, 'full_name' => 'MENG',          'name' => 'MENG',          'slug' => 'meng',          'abbreviation' => 'MENG',  'link' => '',                                        'wikipedia' => '',                                                                             'definition' => 'A stack that includes Express, Node.js, MongoDB, and GPT.' ],
            [ 'id' => 20, 'full_name' => 'MERN',          'name' => 'MERN',          'slug' => 'mern',          'abbreviation' => 'MERN',  'link' => 'https://www.mongodb.com/resources/languages/mern-stack', 'wikipedia' => 'https://en.wikipedia.org/wiki/MEAN_(solution_stack)',           'definition' => 'A variation of the MEAN stack that replaces Angular with React.js front-end.' ],
            [ 'id' => 21, 'full_name' => 'MEVN',          'name' => 'MEVN',          'slug' => 'mevn',          'abbreviation' => 'MEVN',  'link' => null,                                      'wikipedia' => 'https://en.wikipedia.org/wiki/JavaScript_stack#MEAN/MERN/MEVN',                'definition' => 'A variation of the MEAN stack that replaces Angular with Vue.js front-end.' ],
            [ 'id' => 22, 'full_name' => 'MLVN',          'name' => 'MLVN',          'slug' => 'mlvn',          'abbreviation' => 'MLVN',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-level stack that includes MongoDB (database), Linux (operating system), Varnish (software), and Node.js (JavaScript runtime).' ],
            [ 'id' => 23, 'full_name' => 'NMP',           'name' => 'NMP',           'slug' => 'nmp',           'abbreviation' => 'NMP',   'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack that includes Nginx (web server), MySQL or MariaDB (database), and PHP (programming language).' ],
            [ 'id' => 24, 'full_name' => 'OpenACS',       'name' => 'OpenACS',       'slug' => 'openacs',       'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack that includes NaviServer (web server), OpenACS (web application framework), PostgreSQL or Oracle Database (database), and Tcl (scripting language).' ],
            [ 'id' => 25, 'full_name' => 'PERN',          'name' => 'PERN',          'slug' => 'pern',          'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack that includes PostgreSQL (database), Express.js (application controller layer), React (JavaScript library) (web application presentation), and Node.js (JavaScript runtime).' ],
            [ 'id' => 26, 'full_name' => 'PLONK',         'name' => 'PLONK',         'slug' => 'plonk',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack that includes Prometheus (metrics and time-series), Linkerd (service mesh), OpenFaaS (management and auto-scaling of compute), NATS (asynchronous message bus/queue), and Kubernetes (declarative, extensible, scale-out, self-healing clustering).' ],
            [ 'id' => 27, 'full_name' => 'Python-Django', 'name' => 'Python-Django', 'slug' => 'python-django', 'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'A stack utilizes Python as the primary programming language and Django as the web framework.' ],
            [ 'id' => 28, 'full_name' => 'Ruby on Rails', 'name' => 'Ruby on Rails', 'slug' => 'ruby-on-rails', 'abbreviation' => null,    'link' => 'https://rubyonrails.org/',                'wikipedia' => 'https://en.wikipedia.org/wiki/Ruby_on_Rails',                                  'definition' => 'A server-side web application framework written in Ruby under the MIT License.' ],
            [ 'id' => 29, 'full_name' => 'SMACK',         'name' => 'SMACK',         'slug' => 'smack',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack Apache Spark (big data and MapReduce),Apache Mesos (node startup/shutdown), Akka (toolkit) (actor implementation), Apache Cassandra (database), Apache Kafka (messaging).' ],
            [ 'id' => 30, 'full_name' => 'T-REx',         'name' => 'T-REx',         'slug' => 't-rex',         'abbreviation' => 'T-REx', 'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack that includes TerminusDB (scalable graph database), React (JavaScript web framework), and Express.js (framework for Node.js).' ],
            [ 'id' => 31, 'full_name' => 'TALL',          'name' => 'TALL',          'slug' => 'tall',          'abbreviation' => 'TALL',  'link' => 'https://tallstack.dev/',                  'wikipedia' => null,                                                                           'definition' => 'A stack that includes Tailwind CSS, Alpine.js, Laravel, and Livewire used for building dynamic and interactive web applications.' ],
            [ 'id' => 32, 'full_name' => 'WAMP',          'name' => 'WAMP',          'slug' => 'wamp',          'abbreviation' => 'WAMP',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/WampServer',                                     'definition' => 'A solution stack for the Microsoft Windows operating system consisting of the Apache web server, OpenSSL for SSL support, MySQL database and PHP programming language.' ],
            [ 'id' => 33, 'full_name' => 'WIMP',          'name' => 'WIMP',          'slug' => 'wimp',          'abbreviation' => 'WIMP',  'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/WIMP_(software_bundle)',                         'definition' => 'A solution stack of software, partially free and open source software, used to run dynamic web sites on servers.' ],
            [ 'id' => 34, 'full_name' => 'WINS',          'name' => 'WINS',          'slug' => 'wins',          'abbreviation' => 'WINS',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-level stack that includes Windows Server (operating system), Internet Information Services (web server), .NET (software framework), and SQL Server (database).' ],
            [ 'id' => 35, 'full_name' => 'WIPAV',         'name' => 'WIPAV',         'slug' => 'wipav',         'abbreviation' => 'WIPAV', 'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-level stack that includes Windows Server (operating system), Internet Information Services (web server), PostgreSQL (database), ASP.NET (backend web framework), and Vue.js (frontend web framework).' ],
            [ 'id' => 36, 'full_name' => 'WISA',          'name' => 'WISA',          'slug' => 'wisa',          'abbreviation' => 'WISA',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-level stack that includes Windows Server (operating system), Internet Information Services (web server), SQL Server (database), and ASP.NET (web framework).' ],
            [ 'id' => 37, 'full_name' => 'WISAV',         'name' => 'WISAV',         'slug' => 'wsav',          'abbreviation' => 'WSAV',  'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-level stack that includes Windows Server (operating system), Internet Information Services (web server), Microsoft SQL Server, ASP.NET (backend web framework), and Vue.js (frontend web framework).' ],
            [ 'id' => 38, 'full_name' => 'XAMPP',         'name' => 'XAMPP',         'slug' => 'xampp',         'abbreviation' => 'XAMPP', 'link' => '',                                        'wikipedia' => 'https://en.wikipedia.org/wiki/XAMPP',                                          'definition' => 'A free and open-source cross-platform web server solution stack package developed by Apache Friends, consisting mainly of the Apache HTTP Server, MariaDB database, and interpreters for scripts written in the PHP and Perl programming languages.' ],
            [ 'id' => 39, 'full_name' => 'XRX',           'name' => 'XRX',           'slug' => 'xrx',           'abbreviation' => 'XRX',   'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'An OS-agnostic web stack that includes XML database (database such as BaseX, eXist, MarkLogic Server), XQuery (Query language), REST (client interface), and XForms (client).' ],
            [ 'id' => 40, 'full_name' => 'other',         'name' => 'other',         'slug' => 'other',         'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => '' ],
            [ 'id' => 41, 'full_name' => 'Elastic Stack', 'name' => 'Elastic Stack', 'slug' => 'elastic-stack', 'abbreviation' => null,    'link' => '',                                        'wikipedia' => null,                                                                           'definition' => 'A collection of tools for searching, analyzing, and visualizing data, primarily known by its core components: Elasticsearch (the search and analytics engine), Kibana (the visualization and management interface), Beats (the data shippers), and Logstash (the data processing pipeline).' ],
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
