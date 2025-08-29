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
            $table->string('abbreviation', 100)->nullable();
            $table->tinyInteger('open_source')->default(0);
            $table->tinyInteger('proprietary')->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('wiki_page')->nullable();
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1,  'name' => 'Android',   'full_name' => 'Android',                  'slug' => 'android',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.android.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Android_(operating_system)' ],
            [ 'id' => 2,  'name' => 'CentOS',    'full_name' => 'CentOS',                   'slug' => 'centos',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.centos.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/CentOS' ],
            [ 'id' => 3,  'name' => 'ChromeOS',  'full_name' => 'ChromeOS',                 'slug' => 'chromeos',  'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://chromeos.google/', 'wiki_page' => 'https://en.wikipedia.org/wiki/ChromeOS' ],
            [ 'id' => 4,  'name' => 'Debian',    'full_name' => 'Debian',                   'slug' => 'debian',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.debian.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Debian' ],
            [ 'id' => 5,  'name' => 'FreeBSD',   'full_name' => 'FreeBSD',                  'slug' => 'freebsd',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.freebsd.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/FreeBSD' ],
            [ 'id' => 6,  'name' => 'HarmonyOS', 'full_name' => 'HarmonyOS',                'slug' => 'harmonyos', 'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.harmonyos.com/en/', 'wiki_page' => 'https://en.wikipedia.org/wiki/HarmonyOS' ],
            [ 'id' => 7,  'name' => 'iOS',       'full_name' => 'iOS',                      'slug' => 'ios',       'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.apple.com/ios/ios-18/', 'wiki_page' => 'https://en.wikipedia.org/wiki/IOS' ],
            [ 'id' => 8,  'name' => 'iPadOS',    'full_name' => 'iPadOS',                   'slug' => 'ipados',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.apple.com/ipados/ipados-18/', 'wiki_page' => 'https://en.wikipedia.org/wiki/IPadOS' ],
            [ 'id' => 9,  'name' => 'Linux',     'full_name' => 'Linux',                    'slug' => 'linux',     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.linux.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Linux' ],
            [ 'id' => 10, 'name' => 'macOS',     'full_name' => 'macOS',                    'slug' => 'macos',     'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.apple.com/macos/macos-sequoia/', 'wiki_page' => 'https://en.wikipedia.org/wiki/MacOS' ],
            [ 'id' => 11, 'name' => 'OpenBSD',   'full_name' => 'OpenBSD',                  'slug' => 'openbsd',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.openbsd.org/', 'wiki_page' => 'https://en.wikipedia.org/wiki/OpenBSD' ],
            [ 'id' => 12, 'name' => 'openSUSE',  'full_name' => 'openSUSE',                 'slug' => 'suse',      'abbreviation' => 'SUSE', 'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.suse.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/OpenSUSE' ],
            [ 'id' => 13, 'name' => 'RHEL',      'full_name' => 'Red Hat Enterprise Linux', 'slug' => 'rhel',      'abbreviation' => 'RHEL', 'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.redhat.com/en/technologies/linux-platforms/enterprise-linux', 'wiki_page' => 'https://en.wikipedia.org/wiki/Red_Hat_Enterprise_Linux' ],
            [ 'id' => 14, 'name' => 'Ubuntu',    'full_name' => 'Ubuntu',                   'slug' => 'ubuntu',    'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://ubuntu.com/', 'wiki_page' => 'https://en.wikipedia.org/wiki/Ubuntu' ],
            [ 'id' => 15, 'name' => 'Unix',      'full_name' => 'Unix',                     'slug' => 'unix',      'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.opengroup.org/membership/forums/platform/unix', 'wiki_page' => 'https://en.wikipedia.org/wiki/Unix' ],
            [ 'id' => 16, 'name' => 'Windows',   'full_name' => 'Windows',                  'slug' => 'windows',   'abbreviation' => null,   'open_source' => 0, 'proprietary' => 0, 'owner' => null, 'website' => 'https://www.microsoft.com/en-us/windows', 'wiki_page' => 'https://en.wikipedia.org/wiki/Microsoft_Windows' ],
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
