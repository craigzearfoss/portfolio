<?php

use App\Models\Dictionary\OperatingSystem;
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
        Schema::connection($this->database_tag)->create('operating_systems', function (Blueprint $table) {
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
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,  'full_name' => 'Android',                  'name' => 'Android',                  'slug' => 'android',   'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.android.com/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/Android_(operating_system)', 'definition' => 'A modified version of the Linux kernel and other open-source software, designed primarily for touchscreen-based mobile devices such as smartphones and tablet computers.' ],
            [ 'id' => 2,  'full_name' => 'CentOS',                   'name' => 'CentOS',                   'slug' => 'centos',    'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.centos.org/',                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/CentOS',                     'definition' => 'A discontinued Linux distribution that provided a free and open-source community-supported computing platform, functionally compatible with its upstream source, Red Hat Enterprise Linux (RHEL).' ],
            [ 'id' => 3,  'full_name' => 'ChromeOS',                 'name' => 'ChromeOS',                 'slug' => 'chromeos',  'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://chromeos.google/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/ChromeOS',                   'definition' => 'An operating system designed and developed by Google.' ],
            [ 'id' => 4,  'full_name' => 'Debian',                   'name' => 'Debian',                   'slug' => 'debian',    'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.debian.org/',                                                 'wikipedia' => 'https://en.wikipedia.org/wiki/Debian',                     'definition' => 'One of the oldest operating systems based on the Linux kernel, and is the basis of many other Linux distributions.' ],
            [ 'id' => 5,  'full_name' => 'FreeBSD',                  'name' => 'FreeBSD',                  'slug' => 'freebsd',   'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.freebsd.org/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/FreeBSD',                    'definition' => 'A free-software Unix-like operating system descended from the Berkeley Software Distribution (BSD).' ],
            [ 'id' => 6,  'full_name' => 'HarmonyOS',                'name' => 'HarmonyOS',                'slug' => 'harmonyos', 'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.harmonyos.com/en/',                                           'wikipedia' => 'https://en.wikipedia.org/wiki/HarmonyOS',                  'definition' => 'A distributed operating system developed by Huawei for smartphones, tablets, smart TVs, smart watches, personal computers and other smart devices.' ],
            [ 'id' => 7,  'full_name' => 'iOS',                      'name' => 'iOS',                      'slug' => 'ios',       'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.apple.com/ios/ios-18/',                                       'wikipedia' => 'https://en.wikipedia.org/wiki/IOS',                        'definition' => 'A mobile operating system created and developed by Apple for its iPhone line of smartphones.' ],
            [ 'id' => 8,  'full_name' => 'iPadOS',                   'name' => 'iPadOS',                   'slug' => 'ipados',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.apple.com/ipados/ipados-18/',                                 'wikipedia' => 'https://en.wikipedia.org/wiki/IPadOS',                     'definition' => 'A mobile operating system developed by Apple for its iPad line of tablet computers.' ],
            [ 'id' => 9,  'full_name' => 'Linux',                    'name' => 'Linux',                    'slug' => 'linux',     'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.linux.org/',                                                  'wikipedia' => 'https://en.wikipedia.org/wiki/Linux',                      'definition' => 'A family of open source Unix-like operating systems based on the Linux kernel first released on September 17, 1991, by Linus Torvalds.' ],
            [ 'id' => 10, 'full_name' => 'macOS',                    'name' => 'macOS',                    'slug' => 'macos',     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.apple.com/macos/macos-sequoia/',                              'wikipedia' => 'https://en.wikipedia.org/wiki/MacOS',                      'definition' => 'A proprietary Unix-like operating system, derived from OPENSTEP for Mach and FreeBSD, which has been marketed and developed by Apple Inc. since 2001.' ],
            [ 'id' => 11, 'full_name' => 'OpenBSD',                  'name' => 'OpenBSD',                  'slug' => 'openbsd',   'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.openbsd.org/',                                                'wikipedia' => 'https://en.wikipedia.org/wiki/OpenBSD',                    'definition' => 'A security-focused, free software, Unix-like operating system based on the Berkeley Software Distribution (BSD).' ],
            [ 'id' => 12, 'full_name' => 'openSUSE',                 'name' => 'openSUSE',                 'slug' => 'suse',      'abbreviation' => 'SUSE', 'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.suse.com/',                                                   'wikipedia' => 'https://en.wikipedia.org/wiki/OpenSUSE',                   'definition' => 'A free and open-source Linux distribution developed by the openSUSE Project.' ],
            [ 'id' => 13, 'full_name' => 'Red Hat Enterprise Linux', 'name' => 'RHEL',                     'slug' => 'rhel',      'abbreviation' => 'RHEL', 'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.redhat.com/en/technologies/linux-platforms/enterprise-linux', 'wikipedia' => 'https://en.wikipedia.org/wiki/Red_Hat_Enterprise_Linux',   'definition' => 'A commercial Linux distribution developed by Red Hat.' ],
            [ 'id' => 14, 'full_name' => 'Ubuntu',                   'name' => 'Ubuntu',                   'slug' => 'ubuntu',    'abbreviation' => null,   'open_source' => 1, 'proprietary' => 0, 'owner' => null, 'link' => 'https://ubuntu.com/',                                                     'wikipedia' => 'https://en.wikipedia.org/wiki/Ubuntu',                     'definition' => 'A Linux distribution based on Debian and composed primarily of free and open-source software.' ],
            [ 'id' => 15, 'full_name' => 'Unix',                     'name' => 'Unix',                     'slug' => 'unix',      'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.opengroup.org/membership/forums/platform/unix',               'wikipedia' => 'https://en.wikipedia.org/wiki/Unix',                       'definition' => 'A family of multitasking, multi-user computer operating systems that derive from the original AT&T Unix, whose development started in 1969[1] at the Bell Labs.' ],
            [ 'id' => 16, 'full_name' => 'Windows',                  'name' => 'Windows',                  'slug' => 'windows',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://www.microsoft.com/en-us/windows',                                 'wikipedia' => 'https://en.wikipedia.org/wiki/Microsoft_Windows',          'definition' => 'A product line of proprietary graphical operating systems developed and marketed by Microsoft.' ],
            [ 'id' => 17, 'full_name' => 'other',                    'name' => 'other',                    'slug' => 'other',     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => null,                                                                      'wikipedia' => null,                                                       'definition' => '' ],
            [ 'id' => 18, 'full_name' => 'MS-DOS',                   'name' => 'MS-DOS',                   'slug' => 'ms-dos',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'link' => 'https://github.com/microsoft/MS-DOS',                                     'wikipedia' => 'https://en.wikipedia.org/wiki/MS-DOS',                     'definition' => 'An operating system for x86-based personal computers mostly developed by Microsoft. ' ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        OperatingSystem::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('operating_systems');
    }
};
