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
        Schema::connection('career_db')->create('job_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->foreignIdFor( \App\Models\Career\JobSkillCategory::class)->default(1);
            $table->text('description')->nullable();
        });

        $data = [
            [ 'name' => 'Data mining & analysis',  'slug' => 'data-mining-and-analysis', 'job_skill_category_id' => 1 ],
            [ 'name' => 'ETL processes',           'slug' => 'etl-process',             'job_skill_category_id' => 1 ],
            [ 'name' => 'Hadoop & Spark',          'slug' => 'hadoop-and-spark',        'job_skill_category_id' => 1 ],
            [ 'name' => 'NoSQL databases (MongoDB, Cassandra, ElasticSearch)', 'slug' => 'no-sql-databases', 'job_skill_category_id' => 1 ],
            [ 'name' => 'Real-time data processing', 'slug' => 'real-time-data-processing', 'job_skill_category_id' => 1 ],
            [ 'name' => 'Compliance (HIPPA, GDPR, ISO)', 'slug' => 'compliance',        'job_skill_category_id' => 2 ],
            [ 'name' => 'Encryption & IAM (Identity Access Management)', 'slug' => 'encryption-and-iam', 'job_skill_category_id' => 2 ],
            [ 'name' => 'Risk assessment',         'slug' => 'risk-assessment',         'job_skill_category_id' => 2 ],
            [ 'name' => 'Threat detection & response', 'slug' => 'threat-detection-and-response', 'job_skill_category_id' => 2 ],
            [ 'name' => 'Vulnerability scanning',  'slug' => 'vulnerability-scanning',  'job_skill_category_id' => 2 ],
            [ 'name' => 'Adobe creative apps',     'slug' => 'adobe-creative-apps',     'job_skill_category_id' => 3 ],
            [ 'name' => 'Color theory',            'slug' => 'color-theory',            'job_skill_category_id' => 3 ],
            //[ 'name' => 'HTML',                    'slug' => 'html',                    'job_skill_category_id' => 3 ],
            [ 'name' => 'Interactive media',       'slug' => 'interactive-media',       'job_skill_category_id' => 3 ],
            [ 'name' => 'Photoshop',               'slug' => 'photoshop',               'job_skill_category_id' => 3 ],
            [ 'name' => 'Prototyping',             'slug' => 'prototyping',             'job_skill_category_id' => 3 ],
            [ 'name' => 'Responsive design',       'slug' => 'responsive-design',       'job_skill_category_id' => 3 ],
            [ 'name' => 'Sketch',                  'slug' => 'sketch',                  'job_skill_category_id' => 3 ],
            [ 'name' => 'User modeling',           'slug' => 'user-modeling',           'job_skill_category_id' => 3 ],
            [ 'name' => 'UX research',             'slug' => 'ux-research',             'job_skill_category_id' => 3 ],
            [ 'name' => 'Wire framing',            'slug' => 'wire-framing',            'job_skill_category_id' => 3 ],
            [ 'name' => 'CPR and First Aid certification', 'slug' => 'cpr-and-first-aid-certification', 'job_skill_category_id' => 4 ],
            [ 'name' => 'Electronic medical record software', 'slug' => 'electronic-medical-record-software', 'job_skill_category_id' => 4 ],
            [ 'name' => 'Infection control procedures', 'slug' => 'infection-control-procedures', 'job_skill_category_id' => 4 ],
            [ 'name' => 'Medical coding',          'slug' => 'medical-coding',          'job_skill_category_id' => 4 ],
            [ 'name' => 'Medical billing',         'slug' => 'medical-billing',         'job_skill_category_id' => 4 ],
            [ 'name' => 'Patient scheduling systems', 'slug' => 'patient-scheduling-systems', 'job_skill_category_id' => 4 ],
            [ 'name' => 'Radiology/imaging equipment operation', 'slug' => 'radiology-imaging-equipment-operation', 'job_skill_category_id' => 4 ],
            [ 'name' => 'Sonography',              'slug' => 'sonography',              'job_skill_category_id' => 4 ],
            [ 'name' => 'Vital signs monitoring',  'slug' => 'vital-signs-monitoring',  'job_skill_category_id' => 4 ],
            [ 'name' => 'Cloud platforms (AWS, Azure)', 'slug' => 'cloud-platforms',    'job_skill_category_id' => 5 ],
            [ 'name' => 'Help desk software (ServiceNow, Zendesk)', 'slug' => 'help-desk-software', 'job_skill_category_id' => 5 ],
            [ 'name' => 'IT support & trouble shooting', 'slug' => 'it-support-and-trouble-shooting', 'job_skill_category_id' => 5 ],
            [ 'name' => 'System & server administration', 'slug' => 'system-and-server-administration', 'job_skill_category_id' => 5 ],
            [ 'name' => 'Virtualization',          'slug' => 'virtualization',          'job_skill_category_id' => 5 ],
            [ 'name' => 'Automated marketing software', 'slug' => 'automated-marketing-software', 'job_skill_category_id' => 6 ],
            [ 'name' => 'Content creation',        'slug' => 'content-creation',        'job_skill_category_id' => 6 ],
            [ 'name' => 'Content management systems (CMS)', 'slug' => 'content-management-systems', 'job_skill_category_id' => 6 ],
            [ 'name' => 'Copywriting',             'slug' => 'copyrighting',            'job_skill_category_id' => 6 ],
            [ 'name' => 'Digital media',           'slug' => 'digital-media',           'job_skill_category_id' => 6 ],
            [ 'name' => 'Google Analytics',        'slug' => 'google-analytics',        'job_skill_category_id' => 6 ],
            [ 'name' => 'Marketing analytics tools', 'slug' => 'marketing-analytics-tools', 'job_skill_category_id' => 6 ],
            [ 'name' => 'Search engine optimization (SEO)', 'slug' => 'search-engine-optimization', 'job_skill_category_id' => 6 ],
            [ 'name' => 'Social media platforms (Twitter, Facebook, Instagram)', 'slug' => 'social-media-platforms', 'job_skill_category_id' => 6 ],
            [ 'name' => 'Firewall & VPN setup',    'slug' => 'firewall-and-vpn-setup',  'job_skill_category_id' => 7 ],
            [ 'name' => 'IDS/IPS systems',         'slug' => 'ids-ips-systems',         'job_skill_category_id' => 7 ],
            [ 'name' => 'Network monitoring and analysis', 'slug' => 'network-monitoring-and-analysis', 'job_skill_category_id' => 7 ],
            [ 'name' => 'Secure network architecture', 'slug' => 'secure-network-architecture', 'job_skill_category_id' => 7 ],
            [ 'name' => 'SIEM tools',              'slug' => 'siem-tools',             'job_skill_category_id' => 7 ],
            [ 'name' => 'Product lifecycle management', 'slug' => 'product-lifecycle-management', 'job_skill_category_id' => 8 ],
            [ 'name' => 'Product roadmaps',        'slug' => 'product-roadmaps',       'job_skill_category_id' => 8 ],
            [ 'name' => 'Programming skills',      'slug' => 'programming-skills',     'job_skill_category_id' => 8 ],
            [ 'name' => 'QA testing',              'slug' => 'qa-testing',             'job_skill_category_id' => 8 ],
            [ 'name' => 'Requirements gathering',  'slug' => 'requirements-gathering', 'job_skill_category_id' => 8 ],
            [ 'name' => 'User experience design',  'slug' => 'user-experience-design', 'job_skill_category_id' => 8 ],
            [ 'name' => 'Google Suite',            'slug' => 'google-suite',            'job_skill_category_id' => 9 ],
            [ 'name' => 'JIRA',                    'slug' => 'jira',                    'job_skill_category_id' => 9 ],
            [ 'name' => 'Microsoft Office',        'slug' => 'microsoft-office',        'job_skill_category_id' => 9 ],
            [ 'name' => 'Monday.com',              'slug' => 'monday-com',              'job_skill_category_id' => 9 ],
            [ 'name' => 'Salesforce',              'slug' => 'salesforce',              'job_skill_category_id' => 9 ],
            [ 'name' => 'Slack',                   'slug' => 'slack',                   'job_skill_category_id' => 9 ],
            [ 'name' => 'Trello',                  'slug' => 'trello',                  'job_skill_category_id' => 9 ],
            [ 'name' => 'Zapier',                  'slug' => 'zapier',                  'job_skill_category_id' => 9 ],
            [ 'name' => 'Zoom',                    'slug' => 'zoom',                    'job_skill_category_id' => 9 ],
            [ 'name' => 'C/C++',                   'slug' => 'c-c-plus-plus',           'job_skill_category_id' => 10 ],
            [ 'name' => 'C#',                      'slug' => 'c-sharp',                 'job_skill_category_id' => 10 ],
            [ 'name' => 'CSS',                     'slug' => 'css',                     'job_skill_category_id' => 10 ],
            [ 'name' => 'HTML',                    'slug' => 'html',                    'job_skill_category_id' => 10 ],
            [ 'name' => 'Java',                    'slug' => 'java',                    'job_skill_category_id' => 10 ],
            [ 'name' => 'JavaScript',              'slug' => 'javascript',              'job_skill_category_id' => 10 ],
            [ 'name' => 'Kotlin',                  'slug' => 'kotlin',                  'job_skill_category_id' => 10 ],
            [ 'name' => 'Perl',                    'slug' => 'perl',                    'job_skill_category_id' => 10 ],
            [ 'name' => 'PHP',                     'slug' => 'php',                     'job_skill_category_id' => 10 ],
            [ 'name' => 'Python',                  'slug' => 'python',                  'job_skill_category_id' => 10 ],
            [ 'name' => 'Swift',                   'slug' => 'swift',                   'job_skill_category_id' => 10 ],
            [ 'name' => 'Go',                      'slug' => 'go',                      'job_skill_category_id' => 10 ],
            [ 'name' => 'NoSQL',                   'slug' => 'nosql',                   'job_skill_category_id' => 10 ],
            [ 'name' => 'SQL',                     'slug' => 'sql',                     'job_skill_category_id' => 10 ],
            [ 'name' => 'R',                       'slug' => 'r',                       'job_skill_category_id' => 10 ],
            [ 'name' => 'Ruby',                    'slug' => 'ruby',                    'job_skill_category_id' => 10 ],
            [ 'name' => 'Agile methodology',       'slug' => 'agile-methodology',       'job_skill_category_id' => 11 ],
            [ 'name' => 'Budget planning',         'slug' => 'budget-planning',         'job_skill_category_id' => 11 ],
            [ 'name' => 'Project management tools', 'slug' => 'project-management-tools', 'job_skill_category_id' => 11 ],
            [ 'name' => 'Project planning',        'slug' => 'project-planning',        'job_skill_category_id' => 11 ],
            [ 'name' => 'Risk management',         'slug' => 'risk-management',         'job_skill_category_id' => 11 ],
            [ 'name' => 'SCRUM methodology',       'slug' => 'scrum-methodology',       'job_skill_category_id' => 11 ],
            [ 'name' => 'Task management',         'slug' => 'task-management',         'job_skill_category_id' => 11 ],
            [ 'name' => 'Algorithms',              'slug' => 'algorithms',              'job_skill_category_id' => 12 ],
            [ 'name' => 'Applications',            'slug' => 'applications',            'job_skill_category_id' => 12 ],
            [ 'name' => 'Coding',                  'slug' => 'coding',                  'job_skill_category_id' => 12 ],
            [ 'name' => 'Computer programming',    'slug' => 'computer-programming',    'job_skill_category_id' => 12 ],
            [ 'name' => 'Configuration',           'slug' => 'configuration',           'job_skill_category_id' => 12 ],
            [ 'name' => 'Database management',     'slug' => 'database-management',     'job_skill_category_id' => 12 ],
            [ 'name' => 'Data science',            'slug' => 'data-science',            'job_skill_category_id' => 12 ],
            [ 'name' => 'Data visualization',      'slug' => 'data-visualization',      'job_skill_category_id' => 12 ],
            [ 'name' => 'Debugging',               'slug' => 'debugging',               'job_skill_category_id' => 12 ],
            [ 'name' => 'Design',                  'slug' => 'design',                  'job_skill_category_id' => 12 ],
            [ 'name' => 'Documentation',           'slug' => 'documentation',           'job_skill_category_id' => 12 ],
            [ 'name' => 'Implementation',          'slug' => 'implementation',          'job_skill_category_id' => 12 ],
            [ 'name' => 'IOS/Android',             'slug' => 'ios-android',             'job_skill_category_id' => 12 ],
            [ 'name' => 'Machine learning',        'slug' => 'machine-learning',        'job_skill_category_id' => 12 ],
            [ 'name' => 'Modeling',                'slug' => 'modeling',                'job_skill_category_id' => 12 ],
            [ 'name' => 'Programming languages',   'slug' => 'programming-languages',   'job_skill_category_id' => 12 ],
            [ 'name' => 'Security',                'slug' => 'security',                'job_skill_category_id' => 12 ],
            [ 'name' => 'Testing',                 'slug' => 'testing',                 'job_skill_category_id' => 12 ],
        ];
        App\Models\Career\JobSkill::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('job_skills');
    }
};
