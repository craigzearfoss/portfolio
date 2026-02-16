<?php

use App\Models\Dictionary\Category;
use App\Models\System\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('categories', function (Blueprint $table) {
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
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        if ($systemDB = new Database()->where('tag', 'system_db')->first()) {

            // add dictionary_category_id column to the system.tags table
            Schema::connection($systemDB->tag)->table('tags', function (Blueprint $table) {

                $dictionaryDbName = Schema::connection('dictionary_db')->getCurrentSchemaName();

                $table->foreignId('dictionary_category_id')
                    ->nullable()
                    ->constrained($dictionaryDbName . '.categories', 'id')
                    ->onDelete('cascade');
            });
        }

        $data = [
            [ 'id' => 1,  'full_name' => 'algorithm',         'name' => 'algorithm',        'slug' => 'algorithm',        'abbreviation' => null, 'definition' => 'A finite sequence of mathematically rigorous instructions, typically used to solve a class of specific problems or to perform a computation.' ],
            [ 'id' => 2,  'full_name' => 'application',       'name' => 'application',      'slug' => 'application',      'abbreviation' => null, 'definition' => 'Computer software designed to help the user to perform specific tasks.' ],
            [ 'id' => 3,  'full_name' => 'approach',          'name' => 'approach',         'slug' => 'approach',         'abbreviation' => null, 'definition' => 'A process-oriented methodology rooted in behavioral science and psychology of learning to design, develop, and implement instructional materials. ' ],
            [ 'id' => 4,  'full_name' => 'architecture',      'name' => 'architecture',     'slug' => 'architecture',     'abbreviation' => null, 'definition' => 'The set of structures needed to reason about a software system and the discipline of creating such structures and systems.' ],
            [ 'id' => 5,  'full_name' => 'business',          'name' => 'business',         'slug' => 'business',         'abbreviation' => null, 'definition' => 'An organized activity or entity that provides goods or services to meet societal needs, aiming to generate a profit by earning revenue from customers in exchange for value.' ],
            [ 'id' => 6,  'full_name' => 'certificate',       'name' => 'certificate',      'slug' => 'certificate',      'abbreviation' => null, 'definition' => 'An official document attesting to an achievement.' ],
            [ 'id' => 7,  'full_name' => 'concept',           'name' => 'concept',          'slug' => 'concept',          'abbreviation' => null, 'definition' => 'A general notion, abstract idea, or the way in which something is perceived or regarded.' ],
            [ 'id' => 8,  'full_name' => 'database',          'name' => 'database',         'slug' => 'database',         'abbreviation' => null, 'definition' => 'An application to store, manipulate, and retrieve a collection of data.' ],
            [ 'id' => 9,  'full_name' => 'field of study',    'name' => 'field of study',   'slug' => 'field-of-study',   'abbreviation' => null, 'definition' => 'An academic discipline or specialized area of knowledge.' ],
            [ 'id' => 10, 'full_name' => 'interface',         'name' => 'interface',        'slug' => 'interface',        'abbreviation' => null, 'definition' => 'A set of rules, protocols, and tools that enables different software applications to communicate, exchange data, and share functionality.' ],
            [ 'id' => 11, 'full_name' => 'framework',         'name' => 'framework',        'slug' => 'framework',        'abbreviation' => null, 'definition' => 'A structured, reusable set of tools, libraries, and best practices that acts as a foundation for building software applications.' ],
            [ 'id' => 12, 'full_name' => 'language',          'name' => 'language',         'slug' => 'language',         'abbreviation' => null, 'definition' => 'The foundation of software development, allowing developers to create applications, websites, and systems through computer-understandable instructions.' ],
            [ 'id' => 13, 'full_name' => 'library',           'name' => 'library',          'slug' => 'library',          'abbreviation' => null, 'definition' => 'A collection of pre-compiled, reusable code—such as functions, routines, scripts, and configuration data—that developers use to add specific functionality to applications without writing code from scratch.' ],
            [ 'id' => 14, 'full_name' => 'method',            'name' => 'method',           'slug' => 'method',           'abbreviation' => null, 'definition' => 'A structured framework—including models, techniques, and tools—used to plan, manage, and execute the process of creating, testing, and maintaining software applications.' ],
            [ 'id' => 15, 'full_name' => 'model',             'name' => 'model',            'slug' => 'model',            'abbreviation' => null, 'definition' => 'An abstract, simplified representation of a software system’s structure, behavior, and key components (e.g., classes, data, logic) used to analyze and design software before implementation. ' ],
            [ 'id' => 16, 'full_name' => 'network',           'name' => 'network',          'slug' => 'network',          'abbreviation' => null, 'definition' => 'The applications and programs that manage, control, secure, and enable communication between interconnected devices (computers, servers, mobile devices) using protocols, allowing them to share data and resources.' ],
            [ 'id' => 17, 'full_name' => 'operating system',  'name' => 'operating system', 'slug' => 'operating-system', 'abbreviation' => null, 'definition' => 'The fundamental system software that manages computer hardware and software resources, acting as an essential intermediary between the user, application programs, and the computer\'s physical components.' ],
            [ 'id' => 18, 'full_name' => 'paradigm',          'name' => 'paradigm',         'slug' => 'paradigm',         'abbreviation' => null, 'definition' => 'A fundamental style, approach, or philosophy for designing and structuring computer programs and systems.' ],
            [ 'id' => 19, 'full_name' => 'platform',          'name' => 'platform',         'slug' => 'platform',         'abbreviation' => null, 'definition' => 'A foundational environment—comprising operating systems, hardware, or frameworks—that allows developers to build, deploy, and run applications.' ],
            [ 'id' => 20, 'full_name' => 'practice',          'name' => 'practice',         'slug' => 'practice',         'abbreviation' => null, 'definition' => 'The application of established, systematic, and disciplined methods—including principles, processes, and techniques—to the development, maintenance, and management of software systems.' ],
            [ 'id' => 21, 'full_name' => 'process',           'name' => 'process',          'slug' => 'process',          'abbreviation' => null, 'definition' => 'A structured, systematic set of activities, methods, and practices used to develop, maintain, and evolve software systems.' ],
            [ 'id' => 22, 'full_name' => 'product',           'name' => 'product',          'slug' => 'product',          'abbreviation' => null, 'definition' => 'A packaged set of computer programs, procedures, and associated documentation designed to solve specific user problems, usually created for sale or distribution to a market.' ],
            [ 'id' => 23, 'full_name' => 'protocol',          'name' => 'protocol',         'slug' => 'protocol',         'abbreviation' => null, 'definition' => 'A standardized set of rules and conventions governing how data is formatted, transmitted, received, and interpreted between computing systems or software applications.' ],
            [ 'id' => 24, 'full_name' => 'qualification',     'name' => 'qualification',    'slug' => 'qualification',    'abbreviation' => null, 'definition' => 'The documented process of verifying that a software system is installed, configured, and functions according to its intended specifications and requirements.' ],
            [ 'id' => 25, 'full_name' => 'repository',        'name' => 'repository',       'slug' => 'repository',       'abbreviation' => null, 'definition' => 'A centralized digital storage location for software projects, holding source code, libraries, dependencies, configurations, and other digital assets, acting as a version-controlled hub for developers to collaborate, manage changes, and distribute software.' ],
            [ 'id' => 26, 'full_name' => 'server',            'name' => 'server',           'slug' => 'server',           'abbreviation' => null, 'definition' => 'A computer or computer program that manages access to a centralized resource or service in a network.' ],
            [ 'id' => 27, 'full_name' => 'service',           'name' => 'service',          'slug' => 'service',          'abbreviation' => null, 'definition' => 'Software that delivers applications over the internet on a subscription basis, letting users access them via a web browser or app instead of installing them locally, with the provider managing hosting, updates, and maintenance.' ],
            [ 'id' => 28, 'full_name' => 'software',          'name' => 'software',         'slug' => 'software',         'abbreviation' => null, 'definition' => 'The programs and other operating information used by a computer.' ],
            [ 'id' => 29, 'full_name' => 'specification',     'name' => 'specification',    'slug' => 'specification',    'abbreviation' => null, 'definition' => 'A detailed, formal document that defines the intended purpose, functionality, user interface, performance criteria, and constraints of a software system.' ],
            [ 'id' => 30, 'full_name' => 'stack',             'name' => 'stack',            'slug' => 'stack',            'abbreviation' => null, 'definition' => 'A collection of independent software components, like operating systems, databases, languages, and frameworks, that work together in layers to build, run, and support a complete application, from the user interface down to the hardware interaction.' ],
            [ 'id' => 31, 'full_name' => 'standard',          'name' => 'standard',         'slug' => 'standard',         'abbreviation' => null, 'definition' => 'A formally accepted, documented set of rules, specifications, or best practices that define how software, protocols, or data formats should behave and be developed.' ],
            [ 'id' => 32, 'full_name' => 'technique',         'name' => 'technique',        'slug' => 'technique',        'abbreviation' => null, 'definition' => 'A systematic method, procedures, or practices used to design, develop, test, maintain, or manage software systems.' ],
            [ 'id' => 33, 'full_name' => 'technology',        'name' => 'technology',       'slug' => 'technology',       'abbreviation' => null, 'definition' => 'The comprehensive, intangible collection of programming languages, methods, tools, and algorithms used to design, create, test, and maintain computer programs and systems.' ],
            [ 'id' => 34, 'full_name' => 'tool',              'name' => 'tool',             'slug' => 'tool',             'abbreviation' => null, 'definition' => 'A program that is employed in the development, repair, or enhancement of other programs or of hardware.' ],
            [ 'id' => 35, 'full_name' => 'vulnerability',     'name' => 'vulnerability',    'slug' => 'vulnerability',    'abbreviation' => null, 'definition' => 'A security flaw, bug, or weakness in code, design, or architecture that can be exploited by threat actors to compromise a system\'s confidentiality, integrity, or availability. ' ],
            [ 'id' => 36, 'full_name' => 'other',             'name' => 'other',            'slug' => 'other',            'abbreviation' => null, 'definition' => '' ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        new Category()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

        Schema::table($systemDbName.'.tags', function (Blueprint $table) {
            $table->dropForeign('tags_dictionary_category_id_foreign'); // Drops the foreign key constraint
        });

        Schema::connection($this->database_tag)->dropIfExists('categories');
    }
};
