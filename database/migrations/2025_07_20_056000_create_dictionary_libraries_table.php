<?php

use App\Models\Dictionary\Library;
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
        Schema::connection('dictionary_db')->create('libraries', function (Blueprint $table) {
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
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,   'name' => 'Angular Testing Library',      'full_name' => 'Angular Testing Library',      'slug' => 'angular-testing-library',      'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/angular-testing-library/intro/',    'wikipedia' => null,                                                             'definition' => 'Aa light-weight solution for testing web pages by querying and interacting with DOM nodes (whether simulated with JSDOM/Jest or in the browser).' ],
            [ 'id' => 2,   'name' => 'BabylonJS',                    'full_name' => 'BabylonJS',                    'slug' => 'babylonjs',                    'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://www.babylonjs.com/',                                         'wikipedia' => 'https://en.wikipedia.org/wiki/Babylon.js',                       'definition' => 'A JavaScript library and 3D engine for displaying real time 3D graphics in a web browser via HTML5.' ],
            [ 'id' => 3,   'name' => 'Cypress Testing Library',      'full_name' => 'Cypress Testing Library',      'slug' => 'cypress-testing-library',      'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/cypress-testing-library/intro/',    'wikipedia' => null,                                                             'definition' => 'A library that allows the use of dom-testing queries within Cypress end-to-end browser tests.' ],
            [ 'id' => 4,   'name' => 'Flowbite',                     'full_name' => 'Flowbite',                     'slug' => 'flowbite',                     'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://flowbite.com/',                                              'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 5,   'name' => 'Hadoop',                       'full_name' => 'Hadoop',                       'slug' => 'hadoop',                       'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://hadoop.apache.org/',                                         'wikipedia' => 'https://en.wikipedia.org/wiki/Apache_Hadoop',                    'definition' => '' ],
            [ 'id' => 6,   'name' => 'Highcharts',                   'full_name' => 'Highcharts',                   'slug' => 'highcharts',                   'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://www.highcharts.com/',                                        'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 7,   'name' => 'jQuery',                       'full_name' => 'jQuery',                       'slug' => 'jquey',                        'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://jquery.com/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/Jquery',                           'definition' => '' ],
            [ 'id' => 8,   'name' => 'Lucene',                       'full_name' => 'Lucene',                       'slug' => 'lucene',                       'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://lucene.apache.org/',                                         'wikipedia' => 'https://en.wikipedia.org/wiki/Apache_Lucene',                    'definition' => '' ],
            [ 'id' => 9,   'name' => 'Nightwatch Testing Library',   'full_name' => 'Nightwatch Testing Library',   'slug' => 'nightwatch-testing-library',   'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/nightwatch-testing-library/intro/', 'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 10,  'name' => 'NumPy',                        'full_name' => 'NumPy',                        'slug' => 'numpy',                        'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://numpy.org/',                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/NumPy',                            'definition' => '' ],
            [ 'id' => 11,  'name' => 'Polymer',                      'full_name' => 'Polymer',                      'slug' => 'polymer',                      'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://en.wikipedia.org/wiki/Polymer_(library)',                    'wikipedia' => 'https://polymer-library.polymer-project.org/',                   'definition' => '' ],
            [ 'id' => 12,  'name' => 'Preact Testing Library',       'full_name' => 'Preact Testing Library',       'slug' => 'preact-testing-library',       'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => null,                                                                 'wikipedia' => 'https://testing-library.com/docs/preact-testing-library/intro/', 'definition' => '' ],
            [ 'id' => 13,  'name' => 'Puppeteer',                    'full_name' => 'Puppeteer',                    'slug' => 'puppeteer',                    'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://pptr.dev/',                                                  'wikipedia' => 'https://en.wikipedia.org/wiki/Headless_browser#Usage',           'definition' => '' ],
            [ 'id' => 14,  'name' => 'Puppeteer Testing Library',    'full_name' => 'Puppeteer Testing Library',    'slug' => 'puppeteer-testing-library',    'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/pptr-testing-library/intro/',       'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 15,  'name' => 'PyLucene',                     'full_name' => 'PyLucene',                     'slug' => 'pylucene',                     'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://lucene.apache.org/pylucene/',                                'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 16,  'name' => 'PySpark',                      'full_name' => 'PySpark',                      'slug' => 'pyspark',                      'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://spark.apache.org/docs/latest/api/python/index.html',         'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 17,  'name' => 'React',                        'full_name' => 'React',                        'slug' => 'react',                        'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://react.dev/',                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/React_(software)',                 'definition' => '' ],
            [ 'id' => 18,  'name' => 'React Native Testing Library', 'full_name' => 'React Native Testing Library', 'slug' => 'react-native-testing-library', 'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://callstack.github.io/react-native-testing-library/',          'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 19,  'name' => 'React Testing Library',        'full_name' => 'React Testing Library',        'slug' => 'react-testing-library',        'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/react-testing-library/intro/',      'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 20,  'name' => 'ReactiveX',                    'full_name' => 'ReactiveX',                    'slug' => 'reactivex',                    'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://reactivex.io/',                                              'wikipedia' => 'https://en.wikipedia.org/wiki/ReactiveX',                        'definition' => '' ],
            [ 'id' => 21,  'name' => 'Reason Testing Library',       'full_name' => 'Reason Testing Library',       'slug' => 'reason-testing-library',       'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/bs-react-testing-library/intro/',   'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 22,  'name' => 'ReasonReact',                  'full_name' => 'ReasonReact',                  'slug' => 'reasonreact',                  'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://reasonml.github.io/reason-react/',                           'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 23,  'name' => 'Redux',                        'full_name' => 'Redux',                        'slug' => 'redux',                        'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://redux.js.org/',                                              'wikipedia' => 'https://en.wikipedia.org/wiki/Redux_(JavaScript_library)',       'definition' => '' ],
            [ 'id' => 24,  'name' => 'RxJava',                       'full_name' => 'RxJava',                       'slug' => 'rxjava',                       'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://github.com/ReactiveX/RxJava',                                'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 25,  'name' => 'SciPy',                        'full_name' => 'SciPy',                        'slug' => 'scipy',                        'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://scipy.org/',                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/SciPy',                            'definition' => '' ],
            [ 'id' => 26,  'name' => 'Stencil',                      'full_name' => 'Stencil',                      'slug' => 'stencil',                      'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://stenciljs.com/',                                             'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 27,  'name' => 'Svelte Testing Library',       'full_name' => 'Svelte Testing Library',       'slug' => 'svelte-testing-library',       'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/svelte-testing-library/intro/',     'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 28,  'name' => 'TensorFlow',                   'full_name' => 'TensorFlow',                   'slug' => 'tensorflow',                   'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://en.wikipedia.org/wiki/TensorFlow',                           'wikipedia' => 'https://www.tensorflow.org/',                                    'definition' => '' ],
            [ 'id' => 29,  'name' => 'ThreeJS',                      'full_name' => 'ThreeJS',                      'slug' => 'threejs',                      'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://en.wikipedia.org/wiki/Three.js',                             'wikipedia' => 'https://threejs.org/',                                           'definition' => '' ],
            [ 'id' => 30,  'name' => 'Vue Testing Library',          'full_name' => 'Vue Testing Library',          'slug' => 'vue-testing-library',          'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://testing-library.com/docs/vue-testing-library/intro/',        'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 31,  'name' => 'Web Graphics Library',         'full_name' => 'Web Graphics Library',         'slug' => 'web-graphics-library',         'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://get.webgl.org/',                                             'wikipedia' => 'https://en.wikipedia.org/wiki/WebGL',                            'definition' => '' ],
            [ 'id' => 32,  'name' => 'Xamarin',                      'full_name' => 'Xamarin',                      'slug' => 'xamarin',                      'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => null,                                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/Xamarin',                          'definition' => '' ],
            [ 'id' => 33,  'name' => 'Xstate',                       'full_name' => 'Xstate',                       'slug' => 'xstate',                       'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => 'https://xstate.js.org/',                                             'wikipedia' => null,                                                             'definition' => '' ],
            [ 'id' => 34,  'name' => 'other',                        'full_name' => 'other',                        'slug' => 'other',                        'abbreviation' => null, 'open_source' => 0, 'proprietary' => 0, 'owner' => null,        'link' => null,                                                                 'wikipedia' => null,                                                             'definition' => '' ],
        ];

        Library::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('libraries');
    }
};
