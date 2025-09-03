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
        Schema::connection('dictionary_db')->create('operating_systems', function (Blueprint $table) {
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
            [ 'id' => 1,  'full_name' => 'Android',                  'name' => 'Android',                  'slug' => 'android',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.android.com/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/Android_(operating_system)' ],
            [ 'id' => 2,  'full_name' => 'CentOS',                   'name' => 'CentOS',                   'slug' => 'centos',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.centos.org/',                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/CentOS'                     ],
            [ 'id' => 3,  'full_name' => 'ChromeOS',                 'name' => 'ChromeOS',                 'slug' => 'chromeos',  'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://chromeos.google/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/ChromeOS'                   ],
            [ 'id' => 4,  'full_name' => 'Debian',                   'name' => 'Debian',                   'slug' => 'debian',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.debian.org/',                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/Debian'                     ],
            [ 'id' => 5,  'full_name' => 'FreeBSD',                  'name' => 'FreeBSD',                  'slug' => 'freebsd',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.freebsd.org/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/FreeBSD'                    ],
            [ 'id' => 6,  'full_name' => 'HarmonyOS',                'name' => 'HarmonyOS',                'slug' => 'harmonyos', 'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.harmonyos.com/en/',                                           'wikipedia' => 'https://en.wikipedia.org/wiki/HarmonyOS'                  ],
            [ 'id' => 7,  'full_name' => 'iOS',                      'name' => 'iOS',                      'slug' => 'ios',       'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.apple.com/ios/ios-18/',                                       'wikipedia' => 'https://en.wikipedia.org/wiki/IOS'                        ],
            [ 'id' => 8,  'full_name' => 'iPadOS',                   'name' => 'iPadOS',                   'slug' => 'ipados',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.apple.com/ipados/ipados-18/',                                 'wikipedia' => 'https://en.wikipedia.org/wiki/IPadOS'                     ],
            [ 'id' => 9,  'full_name' => 'Linux',                    'name' => 'Linux',                    'slug' => 'linux',     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.linux.org/',                                                  'wikipedia' => 'https://en.wikipedia.org/wiki/Linux'                      ],
            [ 'id' => 10, 'full_name' => 'macOS',                    'name' => 'macOS',                    'slug' => 'macos',     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.apple.com/macos/macos-sequoia/',                              'wikipedia' => 'https://en.wikipedia.org/wiki/MacOS'                      ],
            [ 'id' => 11, 'full_name' => 'OpenBSD',                  'name' => 'OpenBSD',                  'slug' => 'openbsd',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.openbsd.org/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/OpenBSD'                    ],
            [ 'id' => 12, 'full_name' => 'openSUSE',                 'name' => 'openSUSE',                 'slug' => 'suse',      'abbreviation' => 'SUSE', 'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.suse.com/',                                                   'wikipedia' => 'https://en.wikipedia.org/wiki/OpenSUSE'                   ],
            [ 'id' => 13, 'full_name' => 'Red Hat Enterprise Linux', 'name' => 'RHEL',                     'slug' => 'rhel',      'abbreviation' => 'RHEL', 'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.redhat.com/en/technologies/linux-platforms/enterprise-linux', 'wikipedia' => 'https://en.wikipedia.org/wiki/Red_Hat_Enterprise_Linux'   ],
            [ 'id' => 14, 'full_name' => 'Ubuntu',                   'name' => 'Ubuntu',                   'slug' => 'ubuntu',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://ubuntu.com/',                                                     'wikipedia' => 'https://en.wikipedia.org/wiki/Ubuntu'                     ],
            [ 'id' => 15, 'full_name' => 'Unix',                     'name' => 'Unix',                     'slug' => 'unix',      'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.opengroup.org/membership/forums/platform/unix',               'wikipedia' => 'https://en.wikipedia.org/wiki/Unix'                       ],
            [ 'id' => 16, 'full_name' => 'Windows',                  'name' => 'Windows',                  'slug' => 'windows',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.microsoft.com/en-us/windows',                                 'wikipedia' => 'https://en.wikipedia.org/wiki/Microsoft_Windows'          ],
            [ 'id' => 17, 'full_name' => 'other',                    'name' => 'other',                    'slug' => 'other',     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => null,                                                                      'wikipedia' => null                                                       ],
        ];
        \App\Models\Dictionary\OperatingSystem::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('operating_systems');
    }
};
