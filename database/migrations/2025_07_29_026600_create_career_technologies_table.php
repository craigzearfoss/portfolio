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
        Schema::connection('career_db')->create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->foreignIdFor( \App\Models\Career\TechnologyCategory::class)->default(1);
            $table->string('core_technology')->nullable();
            $table->text('description')->nullable();
        });


        $data = [
            [ 'name' => 'Ubuntu',               'slug' => 'ubuntu',              'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'Debian',               'slug' => 'debian',              'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'Fedora',               'slug' => 'fedora',              'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'Red Hat Enterprise Linux (RHEL)', 'slug' => 'red-hat-enterprise-linux', 'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'Centos Linux',         'slug' => 'centos-linux',         'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'Centos Stream',        'slug' => 'centos-stream',        'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'Gentoo',               'slug' => 'gentoo',               'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'OpenSUSE',             'slug' => 'opensuse',             'technology_category_id' => 1, 'core_technology' => 'Linux' ],
            [ 'name' => 'Python',               'slug' => 'python',               'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Java',                 'slug' => 'java',                 'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Go',                   'slug' => 'go',                   'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => '.NET',                 'slug' => 'net',                  'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'ASP',                  'slug' => 'asp',                  'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'JavaScript',           'slug' => 'javascript',           'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'PHP',                  'slug' => 'php',                  'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Kotlin',               'slug' => 'kotlin',               'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Swift',                'slug' => 'swift',                'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'C#',                   'slug' => 'c-sharp',              'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'TypeScript',           'slug' => 'typescript',           'technology_category_id' => 2, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Rust',                 'slug' => 'rust',                 'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Ruby',                 'slug' => 'ruby',                 'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'C',                    'slug' => 'c',                    'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'C and C',              'slug' => 'c-and-c',              'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'R',                    'slug' => 'r',                    'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Dart',                 'slug' => 'dart',                 'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Visual Basic',         'slug' => 'visual-basic',         'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'MATLAB',               'slug' => 'matlab',               'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Objective-C',          'slug' => 'objective-c',          'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'C++',                  'slug' => 'c-plus-plus',          'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'SQL',                  'slug' => 'sql',                  'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Fortran',              'slug' => 'fortran',              'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Pascal',               'slug' => 'pascal',               'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Ada',                  'slug' => 'ada',                  'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Assembly',             'slug' => 'assembly',             'technology_category_id' => 2, 'core_technology' => '' ],
            [ 'name' => 'Oracle',               'slug' => 'oracle',               'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'MySQL',                'slug' => 'mysql',                'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'Microsoft SQL Server', 'slug' => 'microsoft-sql-server', 'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'PostgreSQL',           'slug' => 'postresql',            'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'MongoDB',              'slug' => 'mongodb',              'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'IBM Db2',              'slug' => 'ibm-db2',              'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'Redis',                'slug' => 'redis',                'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'Elasticsearch',        'slug' => 'elasticsearch',        'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'Apache Cassandra',     'slug' => 'apache-cassandra',     'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'MariaDB',              'slug' => 'mariadb',              'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'SQLite',               'slug' => 'sqlite',               'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'Amazon DynamoDB',      'slug' => 'amazon-dynamodb',      'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'Microsoft Access',     'slug' => 'microsoft-access',     'technology_category_id' => 3, 'core_technology' => '' ],
            [ 'name' => 'Nginx',                'slug' => 'nginx',                'technology_category_id' => 4, 'core_technology' => '' ],
            [ 'name' => 'Apache HTTP Server',   'slug' => 'apache-http-server',   'technology_category_id' => 4, 'core_technology' => '' ],
            [ 'name' => 'Microsoft IIS',        'slug' => 'microsoft-iis',        'technology_category_id' => 4, 'core_technology' => '' ],
            [ 'name' => 'Cloudflare server',    'slug' => 'cloudflare-server',    'technology_category_id' => 4, 'core_technology' => '' ],
            [ 'name' => 'LiteSpeed',            'slug' => 'litespeed',            'technology_category_id' => 4, 'core_technology' => '' ],
            [ 'name' => 'Node.js',              'slug' => 'node-js',              'technology_category_id' => 4, 'core_technology' => '' ],
            [ 'name' => 'Laravel',              'slug' => 'laravel',              'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'Symfony',              'slug' => 'symfony',              'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'CodeIgniter',          'slug' => 'codeigniter',          'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'CakePHP',              'slug' => 'cakephp',              'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'Phalcon',              'slug' => 'phalcon',              'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'Yii 2',                'slug' => 'yii-2',                'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'Drupal',               'slug' => 'drupal',               'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'Zend Framework',       'slug' => 'zend-framework',       'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'Slim Framework',       'slug' => 'slim-framework',       'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'FuelPHP',              'slug' => 'fuelphp',              'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'PHPPixie',             'slug' => 'phppixie',             'technology_category_id' => 5, 'core_technology' => 'PHP' ],
            [ 'name' => 'React',                'slug' => 'react',                'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'AngularJS',            'slug' => 'angularJS',            'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Vue.js',               'slug' => 'vue-js',               'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Ember.js',             'slug' => 'ember-js',             'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Preact',               'slug' => 'preact',               'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Svelte',               'slug' => 'svelte',               'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Backbone.js',          'slug' => 'backbone-js',          'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Alpine.js',            'slug' => 'alpine-js',            'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'MithrilJS',            'slug' => 'mithriljs',            'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Aurelia',              'slug' => 'aurelia',              'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'jQuery',               'slug' => 'jquery',               'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'D3.js',                'slug' => 'd3-js',                'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Underscore.js',        'slug' => 'underscore-js',        'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Lodash',               'slug' => 'lodash',               'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Chart.js',             'slug' => 'chart-js',             'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Polymer',              'slug' => 'polymer',              'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Bootstrap',            'slug' => 'bootstrap',            'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Next.js',              'slug' => 'next-js',              'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Mocha',                'slug' => 'mocha',                'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Ionic',                'slug' => 'ionic',                'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Gatsby',               'slug' => 'gatsby',               'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Webix',                'slug' => 'webix',                'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Meteor.js',            'slug' => 'metero-js',            'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'ExpressJS',            'slug' => 'expressjs',            'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Jest',                 'slug' => 'jest',                 'technology_category_id' => 5, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Slick',                'slug' => 'slick',                'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Babel',                'slug' => 'babel',                'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'iziModal',             'slug' => 'izimodal',             'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'ESLint',               'slug' => 'eslint',               'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Shave',                'slug' => 'shave',                'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Webpack',              'slug' => 'webpack',              'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Dojo',                 'slug' => 'dojo',                 'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'InfoVis',              'slug' => 'infovis',              'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Pixi.js',              'slug' => 'pixi-js',              'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'SWFObject',            'slug' => 'swfobject',            'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Three.js',             'slug' => 'three-js',             'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'WinJS',                'slug' => 'winjs',                'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Socket.IO',            'slug' => 'socket-io',            'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'MathJAX',              'slug' => 'mathjax',              'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Blockly',              'slug' => 'blockly',              'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Modernizr',            'slug' => 'modernizr',            'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Verge3D',              'slug' => 'verge3d',              'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Anime.js',             'slug' => 'anime-js',             'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Parsley',              'slug' => 'parsley',              'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'QUint',                'slug' => 'quint',                'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'HTMX',                 'slug' => 'htmx',                 'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Axios',                'slug' => 'axios',                'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Redux',                'slug' => 'redux',                'technology_category_id' => 6, 'core_technology' => 'JavaScript' ],
            [ 'name' => 'Ionos',                'slug' => 'ionos',                'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Hostinger',            'slug' => 'hostinger',            'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Liquid Web',           'slug' => 'liquid-web',           'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'DreamHost',            'slug' => 'dream-host',           'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Bluehost',             'slug' => 'bluehost',             'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'HostGator',            'slug' => 'hostgator',            'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'InMotion',             'slug' => 'inmotion',             'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Green Geeks',          'slug' => 'green-geeks',          'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'ScalaHosting',         'slug' => 'scalahosting',         'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Hosting.com',          'slug' => 'hosting-com',          'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Amazon Web Services (AWS)', 'slug' => 'amazon-web-services', 'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Azure',                'slug' => 'azure',                'technology_category_id' => 7, 'core_technology' => '' ],
            [ 'name' => 'Heroku',               'slug' => 'heroku',               'technology_category_id' => 7, 'core_technology' => '' ],
        ];

        App\Models\Career\Technology::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('technologies');
    }
};
