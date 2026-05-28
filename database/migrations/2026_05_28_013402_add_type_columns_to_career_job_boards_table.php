<?php

use App\Models\Career\JobBoard;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'career_db';

    /**
     * @var string
     */
    protected string $table_name = 'job_boards';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(dbName($this->database_tag) . '.' . $this->table_name, function (Blueprint $table) {
            $table->boolean('free')->default(true)->after('summary');
            $table->boolean('premium')->default(false)->after('free');
            $table->boolean('staffing')->default(false)->after('premium');
            $table->boolean('freelance')->default(false)->after('staffing');
        });

        JobBoard::whereIn('slug',[ 'css-staffing', 'flexjobs','hire-central', 'ihiretechnology', 'remotehunter-com', 'remotejobsfinder-co', 'upwork' ])
            ->update(['free' => false]);

        JobBoard::whereIn('slug', [ 'dailyremote', 'randstad-usa', 'ringside-talent', 'robert-half', 'talentfish', 'trova', 'vernovis' ])
            ->update(['premium' => true]);

        JobBoard::whereIn('slug', [ 'css-staffing', 'flexjobs', 'hire-central', 'ihiretechnology', 'ladders', 'lensa', 'linkedin', 'naukri', 'nexxt', 'remotehub', 'remotehunter-com', 'remotejobsfinder-co', 'remotive', 'simplify', 'snaphunt', 'virtualvocations' ])
            ->update(['staffing' => true]);

        JobBoard::whereIn('slug', [ 'craigslist', 'cybercoders', 'fiverr', 'hubstaff-talent', 'upwork', 'we-work-remotely'])
            ->update(['freelance' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName($this->database_tag) . '.' . $this->table_name, function (Blueprint $table) {
            $table->dropColumn('freelance');
            $table->dropColumn('staffing');
            $table->dropColumn('premium');
            $table->dropColumn('free');
        });
    }
};
