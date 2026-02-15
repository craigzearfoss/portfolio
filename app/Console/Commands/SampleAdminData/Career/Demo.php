<?php

namespace App\Console\Commands\SampleAdminData\Career;

use App\Models\Career\Application;
use App\Models\Career\ApplicationSkill;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\Note;
use App\Models\Career\Reference;
use App\Models\Career\Resume;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

/**
 *
 */
class Demo extends Command
{
    /**
     *
     */
    const string DB_TAG = 'career_db';

    /**
     *
     */
    const string USERNAME = 'demo';

    /**
     * @var int
     */
    protected int $demo = 1;

    /**
     * @var int
     */
    protected int $silent = 0;

    /**
     * @var int|null
     */
    protected int|null $databaseId = null;

    /**
     * @var int|null
     */
    protected int|null $adminId = null;

    /**
     * @var array
     */
    protected array $applicationId = [];

    /**
     * @var array
     */
    protected array $companyId = [];

    /**
     * @var array
     */
    protected array $contactId = [];

    /**
     * @var array
     */
    protected array $applications = [];

    /**
     * @var array
     */
    protected array $resumes = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-' . self::USERNAME . '-career
                            {--demo=1 : Mark all the resources for the admin ' . self::USERNAME . ' as demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the career database with initial data for the admin ' . self::USERNAME . '.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

        // get the database id
        if (!$database = new Database()->where('tag', self::DB_TAG)->first()) {
            echo PHP_EOL . 'Database tag `' .self::DB_TAG . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

        // get the admin
        if (!$admin = new Admin()->where('username', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' . self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->adminId = $admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . self::USERNAME . PHP_EOL;
            echo 'demo: ' . $this->demo . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // career
        // Note that admin_databases and admin_resources rows were already added for the demo admin in the migrations.
        //$this->insertSystemAdminDatabase($this->adminId);
        $this->insertCareerCompanies();
        $this->insertCareerContacts();
        $this->insertCareerReferences();
        $this->insertCareerResumes();
        $this->insertCareerApplications();
        $this->insertCareerCoverLetters();
        $this->insertCareerCommunications();
        $this->insertCareerEvents();
        $this->insertCareerNotes();
        $this->insertCareerApplicationSkill();
        $this->insertCareerCompanyContacts();
    }

    /**
     * @return void
     */
    protected function insertCareerApplications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Application ...\n";

        // get companies
        $companyQuery = new Company()->withoutGlobalScope(AdminPublicScope::class)
            ->select(['id', 'slug'])
            ->where('owner_id', $this->adminId);

        $companies = [];
        foreach ($companyQuery->get() as $company) {
            $companies[$company->slug] = $company->id;
        }

        $this->applicationId = [];
        $maxId = new Contact()->withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=23; $i++) {
            $this->applicationId[$i] = ++$maxId;
        }

        $data = [
            [
                'company_id'             => $companies['choam'] ?? null,
                'role'                   => 'Full-Stack Software Engineer – PHP',
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 1,
                'active'                 => 1,
                'post_date'              => '2025-09-22',
                'apply_date'             => null,
                'close_date'             => null,
                'compensation_min'       => 125000,
                'compensation_max'       => 140000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.linkedin.com/jobs/view/4303651950',
                'link_name'              => "LinkedIn",
                'description'            => null,
            ],
            [
                'company_id'             => $companies['acme-corp'] ?? null,
                'role'                   => 'Senior Software Engineer - Full-Stack Developer',
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 1,
                'active'                 => 1,
                'post_date'              => '2025-09-22',
                'apply_date'             => null,
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Nashville',
                'state_id'               => 48,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/viewjob?jk=fcf10d24947f906b&from=shareddesktop_copy',
                'link_name'              => 'Indeed',
                'description'            => null,
            ],
            [
                'company_id'             => $companies['randstad'] ?? null,
                'role'                   => 'Staff Software Engineer (Fullstack - React/Laravel)',
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 1,
                'active'                 => 1,
                'post_date'              => '2025-09-22',
                'apply_date'             => null,
                'close_date'             => null,
                'compensation_min'       => 101653,
                'compensation_max'       => 151015,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Woodstock',
                'state_id'               => 33  ,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/viewjob?jk=fcf10d24947f906b&from=shareddesktop_copy',
                'link_name'              => 'Indeed',
                'description'            => null,
            ],
            [
                'company_id'             => $companies['sirius-cybernetics-corporation'] ?? null,
                'role'                   => 'Senior DevOps Engineer (Full-Stack Laravel + AWS Infrastructure)',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 1,
                'active'                 => 1,
                'post_date'              => '2025-11-23',
                'apply_date'             => '2025-11-23',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 5,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Oxford',
                'state_id'               => 23,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => 'Did quick apply.',
                'link'                   => 'https://www.linkedin.com/jobs/search-results/?currentJobId=4321380181',
                'link_name'              => 'LinkedIn',
                'description'            => <<<EOD
<h2><a href=\"https://www.linkedin.com/jobs/view/4321380181/?alternateChannel=search&amp;eBP=CwEAAAGas9o0kXeI6XiXSvAibt5v7LXp0lWQACU6gsT5VSyxZt3dFsXwwSEiAWgsW0EW2kwpCx2bEwVrYscTW5lwoW6kttLYZysZwiozS-fk_3L7lBJ7ldKtp0yapZsFyCWTkIOAaialV8JYFjq_OgegHRcmv40Z7vW1RdcRUAYEkzheyiH6fZOq57Ub0vSrp2-MoiuPthOK5EKH27QNDW3Vtrgb07ufF-UyYx9N5RY_SPo9u4U_dVy8ozIQlC_VwnPrfHHGr62tRv_QQAyMrJ7j1YFjWodA8yYB484-VRjwNCeRZALl7UZAbs3xH940_oHAhbHKlvp5duIg-L_CFhJpL74tBNif0MS-2V0lPOm3ZOaWYrycqTuHXjEKkmWhnmRyS2GszaA49ktWo73iBE1l35gRYGNUAEk-vmCI-79gly7jSjUT9Lm4JrDOELP8Fk1YL7eXv_gSTqrGShdgAkUKgicu&amp;refId=nr82G50N%2FFrauZCBSQ49Aw%3D%3D&amp;trackingId=0VV4sPZifvilk4x4DdTODQ%3D%3D\"><strong>Senior DevOps Engineer (Full-Stack Laravel + AWS Infrastructure)</strong></a></h2><p>United States · 2 weeks ago · Over 100 applicants</p><p>Promoted by hirer · <strong>Actively reviewing applicants</strong></p><p><strong>&nbsp;RemoteMatches your job preferences, workplace type is Remote. Full-timeMatches your job preferences, job type is Full-time.</strong></p><p>Applied 8 minutes ago</p><p><a href=\"https://www.linkedin.com/jobs/tracker/applied/\"><strong>See applicationApplied 8 minutes ago for Senior DevOps Engineer (Full-Stack Laravel + AWS Infrastructure)</strong></a></p><h2><a href=\"https://www.linkedin.com/jobs/view/4321380181/?alternateChannel=search&amp;refId=nr82G50N%2FFrauZCBSQ49Aw%3D%3D&amp;trackingId=0VV4sPZifvilk4x4DdTODQ%3D%3D\"><strong>Senior DevOps Engineer (Full-Stack Laravel + AWS Infrastructure)</strong></a></h2><p>Yard Management Solutions · United States (Remote)</p><p>Applied 8 minutes ago</p><p><strong>Show more options</strong></p><p>&nbsp;</p><h2><strong>Take the next step in your job search</strong></h2><p>You\'d be a <strong>top applicant</strong>, based on your skills, experience, and chances of hearing back</p><ul><li><strong>Practice an interview</strong></li></ul><h2><strong>About the job</strong></h2><p>&nbsp;</p><p>Are you a rare breed who thrives at the intersection of application development and infrastructure engineering? Do you architect Laravel applications while also designing the AWS infrastructure they run on? We\'re seeking an experienced individual contributor who can seamlessly move between writing production Laravel code and provisioning AWS infrastructure with Terraform—someone who embodies true DevOps by mastering both development and operations at a senior level.</p><p><br>&nbsp;</p><p><strong>What You\'ll Do:</strong></p><p><br>&nbsp;</p><ul><li><strong>Full-Stack Development: </strong>Design and implement robust server-side logic using PHP and Laravel. Write high-quality, maintainable front-end code using JavaScript, React, semantic HTML, and CSS. Translate design wireframes into responsive web applications.</li><li><strong>Infrastructure Architecture &amp; Operations: </strong>Design, implement, and maintain production infrastructure on AWS. Troubleshoot complex issues spanning from application code through container orchestration to AWS services. Propose and implement architectural patterns that solve real business problems.</li><li><strong>Database Engineering: </strong>Architect and manage MySQL database schemas, ensuring data integrity, security, and performance. Optimize queries and troubleshoot performance issues at both the application and database layers.</li><li><strong>Infrastructure as Code:</strong> Build and manage all infrastructure using Terraform. Establish reusable modules and patterns that the team can leverage for self-service provisioning.</li><li><strong>CI/CD &amp; Automation: </strong>Design and optimize deployment pipelines that enable rapid, safe releases. Implement automation that reduces manual operations and shifts responsibility left to the development team.</li><li><strong>Platform Engineering: </strong>Build self-service tooling, documentation, and processes that enable other engineers to provision, deploy, and operate their services independently.</li><li><strong>Container Platform Management:</strong> Manage and optimize our ECS-based container platform. Debug containerization issues and implement best practices for deployment and scaling.</li><li><strong>Mentorship &amp; Technical Leadership:</strong> Coach engineers on modern development practices, AWS services, IaC, CI/CD, observability, and operational excellence. Evangelize DevOps culture and shift-left mentality across the organization.</li><li><strong>Security &amp; Compliance: </strong>Implement security controls in both application code and infrastructure that support SOC 2 Type 2 compliance. Follow NIST cybersecurity framework and CIS benchmark standards.</li></ul><p><br>&nbsp;</p><p><strong>What We\'re Looking For:</strong></p><p><br>&nbsp;</p><p><strong>Required Development Skills:</strong></p><p><br>&nbsp;</p><ul><li>6+ years hands-on full-stack development with Laravel and its ecosystem</li><li>Strong OOP principles: SOLID, DRY, design patterns (Strategy, Repository, Service patterns, Dependency Injection)</li><li>Database expertise: MySQL schema design, query optimization, performance tuning</li><li>Testing: Pest, PHPUnit, Playwright</li><li>JavaScript, React, and jQuery</li><li>RESTful API design and implementation</li><li>Semantic HTML &amp; CSS with accessibility awareness</li><li>Git version control and branching strategies</li><li>Security mindset: OWASP vulnerabilities, authentication/authorization best practices</li><li>Asynchronous programming and working with web APIs</li></ul><p><br>&nbsp;</p><p><strong>Required Infrastructure Skills:</strong></p><p><br>&nbsp;</p><ul><li>6+ years in DevOps, infrastructure engineering, or similar roles</li><li>Deep hands-on experience with AWS services (ECS, Lambda, RDS, VPC, IAM, CloudWatch, S3, etc.)</li><li>Production experience writing and managing infrastructure with Terraform</li><li>Strong Linux/Unix systems administration</li><li>Docker containerization and container orchestration</li><li>CI/CD pipeline design and implementation</li><li>Scripting proficiency (Bash, Python, or similar)</li><li>Monitoring, logging, and observability platforms</li><li>Experience troubleshooting and debugging production systems across the full stack</li></ul><p><br>&nbsp;</p><p><strong>Highly Desired:</strong></p><p><br>&nbsp;</p><ul><li>NoSQL experience (DynamoDB)</li><li>Experience in SOC 2 and/or GDPR compliant environments</li><li>Track record of mentoring or leading other engineers</li><li>Experience building internal developer platforms</li><li>GitOps practices</li><li>AWS secrets management (Secrets Manager, Parameter Store)</li><li>WebSockets implementation</li></ul><p><br>&nbsp;</p><p><strong>Who You Are:</strong></p><p><br>&nbsp;</p><ul><li>Dual-Domain Expert: You\'re equally comfortable debugging a Laravel service layer and troubleshooting an ECS task definition. You understand how application architecture decisions impact infrastructure requirements and vice versa.</li><li>Systems Thinker: You see the big picture—from code commit to production deployment to ongoing operations. You design solutions that consider the entire lifecycle.</li><li>Technical Problem Solver: You can diagnose issues anywhere in the stack. Whether it\'s a slow database query, a memory leak in a container, or a misconfigured security group, you can find it and fix it.</li><li>Automation Advocate: You believe in automating repetitive work and building systems that scale without proportional increases in operational overhead.</li><li>Collaborative Leader: You have excellent communication skills and build consensus around technical decisions. You mentor effectively and enjoy elevating the skills of those around you.</li><li>Process-Driven: You continuously improve systems, processes, and workflows. You document your work and think about long-term maintainability.</li></ul><p><br>&nbsp;</p><p><strong>Why Join Us:</strong></p><p><br>&nbsp;</p><p>This is a full-time, fully remote IC role with a significant scope of responsibility. You\'ll have a substantial impact on both our application architecture and infrastructure strategy while shaping our DevOps culture. You\'ll work with a focused team of app engineers and supporting personnel, building a Laravel-based SaaS platform that optimizes yard management in logistics. If you\'re ready to apply your unique combination of development and infrastructure expertise to solve challenging technical problems, we\'d love to hear from you.</p><p>&nbsp;</p>
EOD,
            ],
            [
                'company_id'             => $companies['momcorp'] ?? null,
                'role'                   => 'Full Stack Developer II',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 2,
                'active'                 => 1,
                'post_date'              => '2025-11-23',
                'apply_date'             => '2025-11-23',
                'close_date'             => null,
                'compensation_min'       => 85000,
                'compensation_max'       => 95000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Philadelphia',
                'state_id'               => 39,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 0,
                'health'                 => 1,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://mile6.bamboohr.com/careers/32?source=aWQ9MjE%3D',
                'link_name'              => null,
                'description'            => <<<EOD
<h3><strong>Full Stack Developer II</strong></h3><p>United States (Remote)</p><p>Full Stack Developer II</p><p>Location: Remote (Up to 10% travel)</p><p>Type: Full-Time</p><p>Experience Level: 4–6 years professional development experience</p><p>&nbsp;</p><p><strong>About Mile6</strong></p><p>Mile6 creates digital products that drive breakout growth for clients on the cusp of big things. We are growth centered, people-focused drivers of change. You’ll be joining a team made up of navigators, designers, developers, and marketers who promote daily expansion of knowledge for a wide range of disciplines. We trust and empower our team members to do big and great things in and outside of the day-to-day business of Mile6.</p><p>&nbsp;</p><p>Sharing and learning is the responsibility of every member of the team. All teammates work with their manager to establish monthly, quarterly, and annual professional development goals.</p><p>&nbsp;</p><p><strong>What You’ll Do</strong></p><p>As a Full Stack Developer II at Mile6, you’ll contribute to a wide range of digital projects—from internal business tools to hybrid mobile apps to dynamic websites. You’ll work within agile sprint cycles, write clean, testable code, and collaborate with designers and product owners to bring great digital products to life.<br>&nbsp;</p><p>&nbsp;</p><p>You’ll also be encouraged to experiment with new technologies, suggest architectural improvements, and help elevate our dev culture through thoughtful collaboration and code quality.</p><p>&nbsp;</p><p><strong>Responsibilities</strong></p><ul><li>Build and maintain full-stack web and hybrid mobile applications using Laravel, Vue, React, Angular, and Ionic<br>&nbsp;</li><li>Write clean, reusable, and well-documented code for both backend and front-end systems<br>&nbsp;</li><li>Contribute to database design and optimize queries for performance and scalability<br>&nbsp;</li><li>Collaborate with cross-functional teams during sprint planning, backlog grooming, and retrospectives<br>&nbsp;</li><li>Participate in code reviews, pair programming, and internal demos<br>&nbsp;</li><li>Build and consume RESTful APIs, write middleware, and integrate third-party services<br>&nbsp;</li><li>Write and maintain unit tests, prioritize reducing tech debt, and follow TDD where appropriate<br>&nbsp;</li><li>Build and maintain applications using AWS services like S3, RDS, EC2, and Lambda</li><li>Collaborate with product team members (project managers, product owners, product managers, designers) and clients to clarify requirements and translate user stories into working code</li><li>Stay up-to-date with new frameworks, dev tools, and emerging best practices<br><br>&nbsp;</li></ul><p><strong>Required Qualifications</strong></p><ul><li>4–6 years of experience in web and/or app development using modern frameworks</li><li>Strong experience with Laravel and a modern JavaScript framework (Vue preferred, React/Angular acceptable)<br>&nbsp;</li><li>Experience developing hybrid mobile apps (e.g., Ionic, Capacitor, or React Native)<br>&nbsp;</li><li>Fluency with Git, modern JS build tools (Webpack, npm, Yarn), and Composer<br>&nbsp;</li><li>Familiarity with AWS infrastructure and deployments (S3, EC2, RDS, Lambda)<br>&nbsp;</li><li>Ability to write unit tests and work within a TDD mindset<br>&nbsp;</li><li>Solid understanding of web application security best practices<br>&nbsp;</li><li>Experience working in an agile, sprint-based environment<br>&nbsp;</li><li>Strong communication skills, attention to detail, and a collaborative mindset<br><br>&nbsp;</li></ul><p><strong>Bonus Points</strong></p><ul><li>Experience working with Symfony or maintaining legacy PHP applications<br>&nbsp;</li><li>Familiarity with macOS development environments<br>&nbsp;</li><li>Exposure to mobile application deployment workflows<br>&nbsp;</li><li>Interest in mentoring junior developers or leading small technical efforts<br>&nbsp;</li><li>Curiosity about AI and LLMs and how they can enhance dev workflows or digital products<br>&nbsp;</li></ul><p>&nbsp;</p><p><strong>Why Mile6?</strong></p><p>We’re a product-minded agency that builds digital tools for real people. Our dev team thrives in a supportive, remote-first environment that emphasizes personal growth, clean code, and collaborative problem solving.</p><p>&nbsp;</p><p><strong>Benefits Include:</strong></p><ul><li>Remote-friendly team culture<br>&nbsp;</li><li>Unlimited PTO &amp; flexible schedules<br>&nbsp;</li><li>Health, dental, and vision insurance<br>&nbsp;</li><li>Disability and life insurance<br>&nbsp;</li><li>401(k) program<br>&nbsp;</li><li>Paid holidays and professional development support<br>&nbsp;</li><li>A collaborative, respectful, and growth-driven team<br>&nbsp;</li></ul><p>&nbsp;</p><p>If you’re a developer who wants to work on meaningful digital products, collaborate with a talented team, and build tools that help clients grow—Mile6 would love to hear from you.</p><p><br>&nbsp;</p>
EOD,
            ],
            [
                'company_id'             => $companies['rich-industries'] ?? null,
                'role'                   => 'Senior Software Engineer (Laravel / Vue.js)',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-23',
                'apply_date'             => '2025-11-23',
                'close_date'             => null,
                'compensation_min'       => 150000,
                'compensation_max'       => 170000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/jobs?q=laravel&l=remote&from=searchOnHP%2Cwhatautocomplete%2CwhatautocompleteSourceStandard&vjk=df3e956c980ab68e',
                'link_name'              => 'Indeed',
                'description'            => <<<EOD
<h2><strong>Senior Software Engineer (Laravel / Vue.js)- job post</strong></h2><p>Pactfi</p><p>New York, NY•Remote</p><p>$150,000 - $170,000 a year - Full-time</p><p>Pactfi</p><p>New York, NY•Remote</p><p>$150,000 - $170,000 a year</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>Profile insights</strong></h2><p>Here’s how the job qualifications align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Skills</strong></h3><p><strong>Scalable systems</strong></p><p><strong>Scalability</strong></p><p><strong>Data Integration (Data management)</strong></p><ul><li>+ show more</li></ul><p>Do you have experience in <strong>Scalable systems</strong>?</p><p>&amp;nbsp;</p><h2><strong>Job details</strong></h2><p>Here’s how the job details align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Pay</strong></h3><p><strong>$150,000 - $170,000 a year</strong></p><h3><strong>Job type</strong></h3><p><strong>Full-time</strong></p><p>&amp;nbsp;</p><h2><strong>Benefits</strong></h2><p><strong>Pulled from the full job description</strong></p><ul><li>Health insurance</li></ul><p>&amp;nbsp;</p><h2><strong>Full job description</strong></h2><p><strong>About PactFi</strong></p><p>Private asset markets (PE, Private Credit, VC, Real Estate) have 10x to 9.8T in AUM over the past decade and are projected to grow to $17T in the next five years. However, digital infrastructure has not kept pace, with the majority of the market operating predominantly in error-prone, internal-only software solutions.</p><p><br>&nbsp;</p><p>&nbsp;</p><p>PactFi provides secure, end-to-end, operational infrastructure for managing complex private credit transactions. Our web-based application brings together all parties involved in such a transaction to more efficiently allocate capital, complete KYC, share documents, manage funds flow, and more. The platform is secured to a bank-grade standard and we have received both our SOC 2 Type II attestation and our ISO 27001 certification.</p><p><br>&nbsp;</p><p>&nbsp;</p><p>PactFi was developed in close partnership with two of the industry\'s largest players, both of whom represent top 3 players in the private credit space by both size (AUM) and deal activity.</p><p><br>&nbsp;</p><p>&nbsp;</p><p><strong>Job Description</strong></p><p>We are seeking a skilled and ambitious Senior Software Engineer with expertise in Laravel and Vue.js to join our growing team. In this role, you will design and deliver scalable, high-quality solutions that drive the success of our products and services while working closely with the Head of Engineering, Product Managers, and QA teams to align development efforts with strategic goals and user needs.</p><p><br>&nbsp;</p><p>&nbsp;</p><p>Your technical expertise and problem-solving skills will be essential in building innovative solutions, mentoring junior developers, and improving workflows. This is an opportunity to tackle meaningful challenges and make a lasting impact in a collaborative, innovation-focused environment that values continuous growth and improvement.</p><p><br>&nbsp;</p><p>&nbsp;</p><p>If you\'re passionate about solving complex problems, thrive in a hands-on role, and are eager to contribute to a forward-thinking team, we\'d love to hear from you.</p><p><br>&nbsp;</p><p>&nbsp;</p><p><strong>Responsibilities</strong></p><ul><li>Collaborate with the Head of Engineering to align technical implementation with strategic goals.</li><li>Design, develop, and maintain efficient, reusable, and reliable web applications using Laravel and Vue.js.</li><li>Engage with Product Managers to understand requirements and propose innovative technical solutions.</li><li>Coordinate with the QA team to identify, troubleshoot, and resolve issues while ensuring exceptional quality.</li><li>Take ownership of tasks and projects, delivering clean, well-documented code within deadlines.</li><li>Support team leads with tasks such as architectural reviews, code optimizations, and mentoring junior developers.</li><li>Take initiative in tackling a variety of tasks and challenges, including process improvements and exploratory work.</li><li>Stay informed about emerging technologies and trends, and recommend solutions to enhance team performance and application capabilities.</li></ul><p><br>&nbsp;</p><p>&nbsp;</p><p><strong>Skills and Qualifications</strong></p><ul><li>Expert-level proficiency in Laravel PHP framework and Vue.js.</li><li>Strong understanding of RESTful API design principles.</li><li>Proficiency with version control tools such as Git.</li><li>Solid grasp of PHP\'s synchronous behavior and MVC design patterns.</li><li>Deep knowledge of scalable application design principles.</li><li>Experience with user authentication and authorization across multiple systems and environments.</li><li>Ability to integrate multiple data sources and databases into unified systems.</li><li>Familiarity with PHP\'s limitations as a platform and effective workarounds.</li><li>Strong database design and optimization skills, particularly with MySQL or similar databases.</li><li>Exceptional problem-solving skills and a growth-oriented mindset.</li><li>Strong communication skills with a collaborative and proactive approach.</li><li>Experience with testing frameworks such as PEST or Playwright is a plus.</li><li>Experience with AWS a plus.</li></ul><p><br>&nbsp;</p><p>&nbsp;</p><p><strong>Benefits</strong></p><ul><li>Competitive Salary + Equity</li><li>Healthcare Coverage</li><li>Remote optional (Team is based in NYC)</li><li>Tremendous growth opportunity and autonomy</li></ul>
EOD,
            ],
            [
                'company_id'             => $companies['soylent-corporation'] ?? null,
                'role'                   => 'Senior Software Developer (PHP - Laravel)',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-php-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 0,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => '2025-11-26',
                'compensation_min'       => 110000,
                'compensation_max'       => 130000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Longview',
                'state_id'               => 44,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 1,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://dc1prodrecruiting.paylocity.com/Recruiting/Jobs/Details/3655485/iClassPro-Inc?source=LinkedIn_Feed',
                'link_name'              => null,
                'description'            => <<<EOD
<figure class=\"image\"><img src=\"https://media.licdn.com/dms/image/v2/C560BAQFksI6fpwiYHg/company-logo_100_100/company-logo_100_100/0/1676897683925/iclasspro_inc__logo?e=1765411200&amp;v=beta&amp;t=agzpjfmnkaKK2R5uItwcFV7MhGUBzpEvHRtPF-gy7XU\" alt=\"iClassPro - Class Management Software logo\"></figure><p><a href=\"https://www.linkedin.com/company/iclasspro-inc-/life\"><strong>iClassPro - Class Management Software</strong></a></p><p><strong>Share</strong></p><p><strong>Show more options</strong></p><h2><a href=\"https://www.linkedin.com/jobs/view/4316569755/?alternateChannel=search&amp;eBP=NOT_ELIGIBLE_FOR_CHARGING&amp;refId=5Vk3RJGF5viqpRyV5H3K2g%3D%3D&amp;trackingId=FV%2BZcjXnHSqWccu0ZgRUug%3D%3D\"><strong>Senior Software Developer (PHP - Laravel)</strong></a></h2><p>Longview, TX · 1 month ago · Over 100 people clicked apply</p><p>Responses managed off LinkedIn</p><p><strong>&nbsp;RemoteMatches your job preferences, workplace type is Remote. Full-timeMatches your job preferences, job type is Full-time.</strong></p><p><strong>Apply</strong></p><p><strong>SaveSave Senior Software Developer (PHP - Laravel) at iClassPro - Class Management Software</strong></p><h2><a href=\"https://www.linkedin.com/jobs/view/4316569755/?alternateChannel=search&amp;refId=5Vk3RJGF5viqpRyV5H3K2g%3D%3D&amp;trackingId=FV%2BZcjXnHSqWccu0ZgRUug%3D%3D\"><strong>Senior Software Developer (PHP - Laravel)</strong></a></h2><p>iClassPro - Class Management Software · Longview, TX (Remote)</p><p><strong>Apply</strong></p><p><strong>SaveSave Senior Software Developer (PHP - Laravel) at iClassPro - Class Management Software</strong></p><p><strong>Show more options</strong></p><p>&nbsp;</p><h2><strong>Job match is medium, review match details</strong></h2><h3>Your profile matches several of the required qualifications</h3><p>&nbsp;</p><ul><li><strong>Show match details</strong></li><li><strong>Tailor my resume</strong></li><li><strong>Practice an interview</strong></li><li><strong>Create cover letter</strong></li></ul><p>BETA</p><p>Is this information helpful?</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>About the job</strong></h2><p><strong>Description</strong><br><br><strong>Join the Team Behind the World’s Leading Class Management Software!</strong><br><br><strong>Who We Are</strong><br><br>At <strong>iClassPro</strong>, we’re more than just a software company — we’re on a mission to help gym, swim, dance, and cheer businesses spend less time managing and more time doing what they love: coaching, teaching, and building strong communities.<br><br>Our class management platform powers <strong>thousands of youth activity centers worldwide</strong>, helping them run more efficiently, grow their revenue, and achieve long-term success. We’re proud to have earned a spot on the <strong>Inc. 5000 list of fastest-growing private companies</strong> for three years running: 2023, 2024, and 2025!<br><br><strong>What Drives Us</strong><br><br>Our <strong>Core Values</strong> aren’t just words on a wall — they guide everything we do and who we hire:<br><br>&nbsp;</p><ul><li>Commitment to Excellence</li><li>Commitment to Customer Service</li><li>Solutions-Focused Thinking</li><li>Teamwork and Collaboration</li><li>Taking Ownership<br><br>&nbsp;</li></ul><p><strong>What You Will Do</strong><br><br>&nbsp;</p><ul><li>Reviewing program objectives, input data, and output requirements in relation to project requirements</li><li>Formulating program specifications and prototypes</li><li>Transforming software designs and specifications into high-functioning code</li><li>Mentoring and assisting junior and midlevel developers<br><br>&nbsp;</li></ul><p><strong>What You Bring</strong><br><br>&nbsp;</p><ul><li>Minimum of 5 years development experience (Preferably 7+ years\' experience)</li><li>Experienced and proficient (SME) with PHP and Laravel</li><li>Proficient knowledge of Angular and/or React (React knowledge preferred)</li><li>Ability to work proactively and productively with minimal supervision</li><li>Ability to see the big picture with an architectural mindset</li><li>Understands the costs of technical debt and able to weigh business needs against technical preferences<br><br>&nbsp;</li></ul><p><strong>What We Bring</strong><br><br>We believe in taking care of our people.<br><br>&nbsp;</p><ul><li>Generous PTO because work-life balance matters</li><li>Comprehensive health benefits including medical, dental, vision, and more!</li><li>401(k) match to help you plan for your future</li><li>Fun company events that connect our team</li><li>Career growth opportunities in a thriving, purpose-driven company<br><br>&nbsp;</li></ul><p>We want to set you up for success from Day One. That’s why we use the <strong>Culture Index Survey</strong> - a quick tool that helps align your natural strengths with our roles and teams.<br><br>All applicants will need to take the survey during the application process. Want to be proactive? Visit Culture Index once you have submitted the application.<br><br>iClassPro is an Equal Opportunity Employer.<br><br>Applicants must be authorized to work for any employer in the U.S. We will not participate in STEM OPT programs, nor sponsor or take over sponsorship of an employment visa for this position.<br><br><strong>E-Verify</strong> is used to verify authorization to work in the U.S.</p><p>&nbsp;</p><h3><strong>Benefits found in job post</strong></h3><p>&nbsp;</p><ul><li>401(k)</li></ul>
EOD,
            ],
            [
                'company_id'             => $companies['very-big-corporation-of-america'] ?? null,
                'role'                   => 'Senior Fullstack Software Engineer',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 1,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 130000,
                'compensation_max'       => 170000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Homer',
                'state_id'               => 2,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => null,
                'link_name'              => null,
                'description'            => <<<EOD
<h2><a href=\"https://www.linkedin.com/jobs/view/4216700740/?alternateChannel=search&amp;eBP=CwEAAAGat0LSAwWaA4qZXkj2qmdng0tdAMARvbLahjx4drv4JfEisI2IzZ801yGCgoBGOpQ7g20aNchqE_RAWlnn_SzYL6UiZ7cZTvcxxvGvHTK1_XBW2Z02kBm-3hcwTD0EOHTkU5cQWk6abQOKF7D8zZtk6s3-DOYxQpHv9UGxkN0aYkXLYlRfh5usa8X6pgUCWr28EXnZMwYKGq7jT9GqSw03QDWpPEHRxBH7Pb99EkYnmWW_tpmwzPSVmuKVXWQR2mwBfqAQOkki4hOkFe048B4qd0RiBvqtZpRft-FqAbqzXp_189_vC9h_Yi71GFfmpivhf0x5yYrPnBka2LrQNLEfjg1b4ESjCy4ekvsAb_MMBhZGgqC09gLzaCs77ETwzidSaRw_qgo9x1VVhSRE0W4tKEPX1Mq8KI5keICRgWTcmH3tfEdq9uw2Qb-gAPu3AfUnefehF3ReuDmLRznmE_xM_aGuv6dhtvpdKaEULfGmCbs7KHlAhK1BsXBYSQ&amp;refId=5Vk3RJGF5viqpRyV5H3K2g%3D%3D&amp;trackingId=0Mlm%2FqGY20R4y%2BLjcxvqTA%3D%3D\"><strong>Senior Fullstack Software Engineer</strong></a></h2><p>United States · Reposted 2 days ago · Over 100 people clicked apply</p><p>Promoted by hirer · Responses managed off LinkedIn</p><p><strong>$130K/yr - $170K/yr RemoteMatches your job preferences, workplace type is Remote. Full-timeMatches your job preferences, job type is Full-time.</strong></p><p><strong>Apply</strong></p><p><strong>SaveSave Senior Fullstack Software Engineer at Wild Alaskan Company</strong></p><p><img src=\"https://grnh.se/ff637b584us\"></p><h2><a href=\"https://www.linkedin.com/jobs/view/4216700740/?alternateChannel=search&amp;refId=5Vk3RJGF5viqpRyV5H3K2g%3D%3D&amp;trackingId=0Mlm%2FqGY20R4y%2BLjcxvqTA%3D%3D\"><strong>Senior Fullstack Software Engineer</strong></a></h2><p>Wild Alaskan Company · United States (Remote)</p><p><strong>Apply</strong></p><p><strong>SaveSave Senior Fullstack Software Engineer at Wild Alaskan Company</strong></p><p><strong>Show more options</strong></p><p>&nbsp;</p><h2><strong>Job match is medium, review match details</strong></h2><h3>Your profile matches several of the required qualifications</h3><p>&nbsp;</p><ul><li><strong>Show match details</strong></li><li><strong>Tailor my resume</strong></li><li><strong>Practice an interview</strong></li><li><strong>Create cover letter</strong></li></ul><p>BETA</p><p>Is this information helpful?</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>People you can reach out to</strong></h2><figure class=\"image\"><img src=\"https://media.licdn.com/dms/image/v2/D5603AQG4vFnQpqr56A/profile-displayphoto-shrink_100_100/profile-displayphoto-shrink_100_100/0/1729133072102?e=1765411200&amp;v=beta&amp;t=bO9JXB9JRUaSt9wPM_0Or37dceZpNKw6Z1gV0HMnqyg\" alt=\"Madalyn profile photo\"></figure><p><a href=\"https://www.linkedin.com/in/madalyn-arthur-1802031b2\"><strong>Madalyn profile photo</strong></a></p><p><a href=\"https://www.linkedin.com/in/madalyn-arthur-1802031b2\"><strong>Madalyn Arthur Madalyn Arthur is verified</strong></a></p><p><a href=\"https://www.linkedin.com/in/madalyn-arthur-1802031b2\"><strong>·&nbsp;3rd</strong></a></p><p><a href=\"https://www.linkedin.com/in/madalyn-arthur-1802031b2\"><strong>Food Safety and Quality Systems Manager</strong></a></p><p><a href=\"https://www.linkedin.com/in/madalyn-arthur-1802031b2\"><strong>School alum from Penn State University</strong></a></p><p><strong>Message</strong></p><h2><strong>About the job</strong></h2><p><strong>About Us</strong><br><br>Wild Alaskan Company’s mission is to accelerate humanity’s transition to sustainable food systems by fostering meaningful, interconnected relationships between human beings, wild seafood and the planet.<br><br>We deliver wild-caught, sustainable seafood to households across the United States. Powered by our custom-built eCommerce platform and three generations of history and expertise in the Alaskan fishing industry, we constantly strive to meet our promise of a top-notch product and experience. And we do it all in a fully-remote environment that is fast-paced, challenging, and fun.<br><br><strong>What To Expect</strong><br><br>Wild Alaskan Company is a data-driven, tech-enabled marketing and cold chain logistics company that sells seafood. Our mission is to accelerate humanity’s transition to sustainable food systems by fostering meaningful, interconnected relationships between human beings, wild seafood, and the planet. To meet this goal, WAC is constantly striving to innovate technology that facilitates (a) a more connected and vertically integrated supply chain via a proprietary end-to-end logistics platform, (b) a seamless buying experience via best-in-class ecommerce and POS solutions, and (c) human-to-human connectivity via proprietary CRM, content platform and member portal. To that end, WAC is seeking a hardworking and passionate Senior Software Engineer to join the team.<br><br><strong>What You\'ll Do</strong><br><br>As a Senior Software Engineer, you will be joining a growing team of talented, driven engineers who are passionate about their work and the mission. You will have an opportunity to make an important difference in the future of sustainable food systems by building technology that enables the efficient production, access, and distribution of food to individuals across the globe. You’ll be bringing your expertise to the technology stack of Wild Alaskan’s proprietary order and inventory management systems, as well as our ecommerce and content platforms.<br><br>You will work as an individual contributor in collaboration with the VP of Software Architecture, Digital Product leadership, Product Managers, Principal Engineer, other Senior Engineers, and the Data Science and Analytics Team to fully support and expand our home-grown technology stack in Laravel and Vue.js.<br><br><strong>Your Day-to-Day</strong><br><br>&nbsp;</p><ul><li>Develop robust, scalable, and efficient web applications using Laravel and Vue.js, ensuring high performance and optimal user experience.</li><li>Collaborate with product managers, designers, and other stakeholders to gather requirements and translate them into technical specifications.</li><li>Design and implement database structures and queries to support application functionality and performance.</li><li>Write clean, maintainable, and well-documented code following coding standards and best practices.</li><li>Conduct code reviews and provide constructive feedback to your peers to ensure code quality and adherence to standards.</li><li>Optimize application performance through performance profiling, code optimization, and caching techniques.</li><li>Troubleshoot and debug complex issues, identify root causes and implement effective solutions.</li><li>Stay up-to-date with industry trends and emerging technologies and apply them to improve our development processes and methodologies.</li><li>Share your knowledge and expertise to foster team growth.</li><li>Collaborate with the QA team to develop comprehensive test plans and ensure high-quality software delivery.</li><li>Participate in Agile development methodologies, including sprint planning, task estimation, and progress tracking.</li><li>Continuously monitor and improve application security, identifying and mitigating potential vulnerabilities.<br><br><br>&nbsp;</li></ul><p><strong>What You Bring</strong><br><br>&nbsp;</p><ul><li>Mastery of Laravel and Vue.js with 8+ years of experience.</li><li>Strong OOP and code planning proficiency.</li><li>Mastery of building RESTful APIs and single-page applications.</li><li>Solid understanding of relational databases (e.g., MySQL, PostgreSQL) and ability to write efficient SQL queries.</li><li>Strong TDD and testing methodologies (PHPUnit.)</li><li>Proficiency in front-end web technologies such as HTML5, CSS3, JavaScript, and related frameworks (e.g., Bootstrap, Tailwind CSS).</li><li>Mastery of version control systems (e.g., Git) and familiarity with collaborative development workflows (we use feature branching and rebase).</li><li>Familiarity with deployment and hosting environments, including cloud platforms (e.g., AWS) and containerization (e.g., Docker).</li><li>Ability to identify technical debt and develop effective strategies to mitigate it.</li><li>Ability to identify gaps in the technology used and propose suitable solutions for enhancing system functionality.</li><li>Ability to plan and execute incremental improvements to continuously enhance the software system\'s performance and functionality.</li><li>Excellent communication skills and ability to collaborate effectively with cross-functional teams.</li><li>Self-sufficient and capable of working independently to complete tasks and troubleshoot issues.</li><li>Self-motivated with a passion for learning and staying updated with the latest technologies and industry trends.<br><br><br>&nbsp;</li></ul><p><strong>Nice to Haves</strong><br><br>&nbsp;</p><ul><li>Knowledge of server-side rendering (SSR) and modern JavaScript Framework tools (e.g., Nuxt.js)</li><li>Knowledge of Typescript</li><li>Familiarity with DevOps practices and CI/CD pipelines</li><li>Experience with UI/UX</li><li>E-commerce Experience</li><li>Experience using BI Tools such as Looker and Google Analytics</li><li>Food Industry experience</li><li>Experience working in start-up environments<br><br><br>&nbsp;</li></ul><p><strong>Location&nbsp;</strong><br><br>100% remote with occasional travel for in-person team and companywide retreats.<br><br><i>The starting salary range for this position is $130,000 - $170,000, commensurate with skills and experience. Wild Alaskan’s benefits package includes health, vision, and dental insurance, 401k, PTO, safe/sick time, vacation, parental leave and more, as well as a delicious box of free fish every month.</i><br><br>Wild Alaskan participates in E-Verify. Please see the <a href=\"https://www.e-verify.gov/sites/default/files/everify/posters/EVerifyParticipationPoster.pdf\">Notice of E-Verify Participation</a> and <a href=\"https://www.e-verify.gov/sites/default/files/everify/posters/IER_RightToWorkPoster%20Eng_Es.pdf\">Right to Work</a> posters for more information.<br><br><i>Diversity of backgrounds and perspectives makes us stronger. We’re committed to creating a work environment that fosters growth, celebrates diversity and fundamentally makes all teammates feel welcome, accepted, nurtured and respected. As an equal Opportunity Employer, Wild Alaskan Company does not discriminate against candidates on the basis of their disability, sex, race, gender identity, sexual orientation, religion, national origin, age, veteran status, or any other protected status under the law.&nbsp;</i><br><br><i>If reasonable accommodation is needed to participate in the job application or interview process, to perform essential job functions, and/or to receive other benefits and privileges of employment, please contact <strong>people@wildalaskancompany.com</strong>. Please note this email cannot provide application status updates.</i></p><p>&nbsp;</p><h3><strong>Benefits found in job post</strong></h3><p>&nbsp;</p><ul><li>401(k)</li><li>Dental insurance</li></ul>
EOD,
            ],
            [
                'company_id'             => $companies['frobozz-magic-co'] ?? null,
                'role'                   => 'Software Development Engineer III',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 3,
                'active'                 => 0,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => '2025-11-28',
                'compensation_min'       => 125000,
                'compensation_max'       => 140000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Tustin',
                'state_id'               => 5,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => null,
                'link_name'              => null,
                'description'            => <<<EOD
<h2><strong>Software Development Engineer III</strong></h2><p><strong>ID</strong></p><p>2025-7610</p><p><strong>Job Locations</strong></p><p>US</p><p><strong>Category</strong></p><p>Technology</p><p><strong>Type</strong></p><p>Full Time</p><h2><strong>Overview</strong></h2><p><strong>Position</strong>:&nbsp; Sr <strong>PHP Larave</strong>l Developer</p><p>&nbsp;</p><p><strong>Salary</strong>:&nbsp; $125K - 140K/yr d.o.e.</p><p>*Actual compensation may vary from posting based on geographic location, work experience, education, and/or skill level.</p><p>&nbsp;</p><p><strong>Location: </strong>Remote OK (If living within 31 miles of Tustin, CA or Austin, TX will need to be able to work 2 days on-site)</p><p>&nbsp;</p><p><strong>Position Summary:</strong></p><p>We are seeking a highly skilled PHP professional to lead the design, development, and implementation of our Customer Relationship Management platform built with intuitive and innovative technology that will enable client facing teams to attract, convert, and retain more clients on autopilot, so they can earn more without working more.&nbsp; Your strong technical expertise and problem-solving abilities will be essential to driving the success of our projects.</p><p>&nbsp;</p><p><strong>*Disclaimer</strong>:&nbsp;Identity Verification checks are in place throughout the Candidate journey to prevent candidate fraud</p><h2><strong>Responsibilities</strong></h2><ul><li>Design, develop, and maintain robust PHP applications, ensuring code quality and adherence to best practices.</li><li>Provide guidance and mentorship to development teams, ensuring adherence to best practices through training, code reviews, and active participation in planning meetings.</li><li>Work closely with engineering, product teams, and vendors to evaluate software solutions and solve integration challenges.</li><li>Create and maintain comprehensive documentation for new and existing systems, including UML, architectural, and data flow diagrams.</li><li>Provide technical guidance and supervision to our teams. Ensure they follow best practices through training, examples, documentation, by conducting code reviews and engaging during team planning meetings.</li><li>Analyze and optimize application performance and scalability, implementing solutions to address identified challenges.</li><li>Work with DevOps engineers to establish robust observability standards and ensure smooth production deployment, and post-production reliability.</li><li>Work with vendors to evaluate software and solve integration challenges.</li></ul><h2><strong>Qualifications</strong></h2><ul><li>Bachelor\'s degree in computer science or work-related equivalent.</li><li>5+ years of PHP (Laravel, CodeIgniter) software development experience.</li><li>3+ years’ experience with database technologies such as MySQL, MariaDB, MySQL Aurora experience</li><li>5+ years’ front-end experience with Vue and React.</li><li>3+ years’ production experience with Kubernetes, Helm, AKS/EKS.</li><li>Familiarity with AWS products: S3, EKS,</li><li>Familiarity writing documentation and creating UML, architectural and data flow diagrams.</li><li>Experience building integrations with vendors, and in-house APIs.</li><li>Knowledge in performance, scalability, enterprise system architecture, and engineering best practices.</li><li>Excellent communication and interpersonal skills working across multiple geographies.</li></ul><p>&nbsp;</p><p><strong>Desired Skills:</strong></p><ul><li>Proficiency with Nuxt and/or Next.js, .NET Core, (C#).</li><li>Proficiency in Azure Cloud including App Services, Functions, Service Bus, Monitoring, Cosmos DB, Blob Storage, Event Grid, ElasticSearch, SQL Server.</li><li>Experience optimizing applications or systems to maximize performance at scale.</li><li>Working knowledge of Banking, Financial Services or FinTech.</li><li>A deep understanding of cross functional teams.</li><li>Experience in production deployments and resolving production issues.</li></ul><p><strong>Work Authorization:</strong> Must be able to verify identity and employment eligibility to work in the U.S.</p><p><strong>Other Duties: </strong>This job profile is not intended to be an all-inclusive list of job duties and responsibilities, as one may perform additional related duties as assigned in order to meet the needs of the organization.</p><p>Physical Demands: The physical demands described here are representative of those that must be met by an employee to successfully perform the essential functions of this job. Reasonable accommodations may be made to enable individuals with disabilities to perform the essential functions. Must be able to lift up to ten pounds. Primary functions require sufficient physical ability and mobility to work in an office setting; to stand or sit for prolonged periods of time; to occasionally stoop, bend, kneel, crouch, reach, and twist; to lift, carry, push, and/or pull light to moderate amounts of weight; to operate office equipment requiring repetitive hand movement and fine coordination including use of a keyboard; and to verbally communicate to exchange information. VISION: See in the normal visual range with or without correction. HEARING: Hear in the normal audio range with or without correction.</p><p>[EOE/M/F/D/V. Drug-free workplace.]</p><p>&nbsp;</p><p><strong>Pay Transparency Disclosure</strong>: If based in New American Funding’s offices, this role has the annual base salary range stated below.</p><p>Job level and actual compensation will be decided based on factors including, but not limited to, individual qualifications objectively assessed during the interview process (including skills and prior relevant experience, potential impact, and scope of role), market demands, and specific work location. The listed range is a guideline, and the range for this role may be modified. For roles that are available to be filled remotely, the pay range is localized according to employee work location by a factor of between 80% and 100% of range. Please discuss your specific work location with your recruiter for more information.</p><p>&nbsp;</p><p>New American Funding offers competitive package of additional benefits, including health, dental &amp; vision, retirement with company contribution, parental leave , mental health &amp; wellness benefits, and generous PTO. New American Funding also offers sales incentive pay for most sales roles and an annual bonus plan for eligible non-sales roles. New American Funding’s compensation and benefits are subject to change and may be modified in the future.</p><p>&nbsp;</p><p>#LI-JS3</p><p>#LI-REMOTE</p>
EOD,
            ],
            [
                'company_id'             => $companies['warbucks-industries'] ?? null,
                'role'                   => 'Sr. Software Engineer',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 3,
                'active'                 => 1,
                'post_date'              => '2025-11-21',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'New York',
                'state_id'               => 33,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.parentoleave.com/careers?gh_jid=4010113009&gh_src=auk6sbgs9us&source=LinkedIn#job-postings',
                'link_name'              => null,
                'description'            => <<<EOD
<h2>Sr. Software Engineer</h2><p>Remote</p><p><strong>About Parento</strong></p><p>Parento is the first provider for paid parental leave, distributing the first and only paid parental leave insurance and parental support program. Our holistic program enables companies to offer paid maternity and paternity leave to all employees.</p><p>Designed to support working parents while alleviating HR’s workload, Parento’s white glove leave concierge handles the complexities of leave management, payroll calculations, compliance, and claims, while providing emotional and parent coaching for employees. Our proprietary program boasts a 95% return-to-work rate and guides employees through the process before, during, and after leave to ensure a seamless re-onboarding.</p><p><strong>About&nbsp;the&nbsp;Role</strong></p><p>We’re&nbsp;seeking&nbsp;a&nbsp;driven,&nbsp;curious,&nbsp;and&nbsp;detail-oriented&nbsp;<strong>Software&nbsp;Engineer&nbsp;</strong>to join our growing engineering team. This role is ideal for someone with strong skills in&nbsp;<strong>PHP</strong>,&nbsp;<strong>Laravel</strong>,&nbsp;and&nbsp;<strong>VueJS</strong>, that\'s eager to contribute to real-world SaaS products and platforms. You\'ll work on core systems powering our customer-facing web portal and backend infrastructure while shaping the future of a modern insurance-based program.</p><p><strong>What&nbsp;You’ll&nbsp;Do</strong></p><ul><li>Develop,&nbsp;test,&nbsp;and&nbsp;maintain&nbsp;scalable&nbsp;backend&nbsp;services&nbsp;that&nbsp;power&nbsp;an&nbsp;enterprise&nbsp;customer&nbsp;portal&nbsp;using&nbsp;<strong>PHP</strong>&nbsp;and&nbsp;the&nbsp;<strong>Laravel</strong>&nbsp;framework.</li><li>Build&nbsp;and&nbsp;enhance&nbsp;frontend&nbsp;interfaces&nbsp;using&nbsp;<strong>Tailwind&nbsp;CSS</strong>&nbsp;and&nbsp;<strong>VueJS</strong>,&nbsp;ensuring&nbsp;responsive,&nbsp;user-friendly&nbsp;design.</li><li>Collaborate&nbsp;closely&nbsp;with&nbsp;our&nbsp;product&nbsp;manager,&nbsp;designers,&nbsp;VP&nbsp;of&nbsp;Engineering,&nbsp;and&nbsp;other&nbsp;internal&nbsp;stakeholders&nbsp;to&nbsp;turn&nbsp;requirements&nbsp;into&nbsp;robust&nbsp;features</li><li>Work&nbsp;on&nbsp;SaaS-based&nbsp;architecture,&nbsp;helping&nbsp;optimize&nbsp;performance,&nbsp;maintainability,&nbsp;reliability&nbsp;and&nbsp;scalability.</li><li>Participate&nbsp;in&nbsp;code&nbsp;reviews,&nbsp;sprint&nbsp;planning,&nbsp;and&nbsp;system&nbsp;design&nbsp;discussions.&nbsp;Comfortable&nbsp;using&nbsp;AI&nbsp;code-generation&nbsp;tools&nbsp;(Cursor&nbsp;AI,&nbsp;Claude,&nbsp;Copilot,&nbsp;etc.)</li><li>Assist&nbsp;in&nbsp;integrating,&nbsp;training&nbsp;and&nbsp;applying&nbsp;<strong>machine&nbsp;learning&nbsp;algorithms</strong>&nbsp;or&nbsp;<strong>big&nbsp;data&nbsp;pipelines</strong>&nbsp;to&nbsp;production&nbsp;workflows</li><li>Contribute&nbsp;to&nbsp;improving&nbsp;the&nbsp;developer&nbsp;experience,&nbsp;CI/CD&nbsp;processes,&nbsp;and&nbsp;internal&nbsp;tools&nbsp;that&nbsp;help&nbsp;with&nbsp;developer&nbsp;productivity</li></ul><p><strong>Technical skills and experience</strong></p><ul><li>Solid proficiency in&nbsp;<strong>PHP</strong>,&nbsp;<strong>Laravel</strong>,&nbsp;and&nbsp;<strong>VueJS</strong></li><li>Academic&nbsp;or&nbsp;hands-on&nbsp;experience&nbsp;working&nbsp;on&nbsp;<strong>SaaS&nbsp;products</strong>&nbsp;and&nbsp;<strong>web&nbsp;portals</strong></li><li>Exposure&nbsp;to&nbsp;or&nbsp;interest&nbsp;in&nbsp;big&nbsp;data&nbsp;processing&nbsp;and&nbsp;<strong>machine&nbsp;learning</strong>&nbsp;concepts</li><li>Familiarity&nbsp;with&nbsp;version&nbsp;control&nbsp;systems&nbsp;(e.g.,&nbsp;Git),&nbsp;REST&nbsp;APIs,&nbsp;and&nbsp;databases&nbsp;like&nbsp;MySQL&nbsp;or&nbsp;MariaDB.&nbsp;Familiarity&nbsp;with&nbsp;analytics&nbsp;tools&nbsp;such&nbsp;as&nbsp;Metabase.</li><li>Familiarity&nbsp;with&nbsp;a&nbsp;cloud-based&nbsp;architecture&nbsp;that&nbsp;spans&nbsp;multiple&nbsp;public&nbsp;clouds&nbsp;(AWS,&nbsp;Digital&nbsp;Ocean,&nbsp;Google&nbsp;Cloud).</li><li>Excellent&nbsp;written&nbsp;communication&nbsp;skills&nbsp;(we&nbsp;collaborate&nbsp;a&nbsp;LOT&nbsp;on&nbsp;email&nbsp;&amp;&nbsp;Slack).</li></ul><p><strong>Preferred&nbsp;(But&nbsp;Not&nbsp;Required)</strong></p><ul><li>Prior&nbsp;freelance&nbsp;or&nbsp;full-time&nbsp;work&nbsp;experience&nbsp;in&nbsp;<strong>Fintech</strong>&nbsp;or&nbsp;<strong>InsurTech</strong>&nbsp;industries</li><li>Certification&nbsp;on&nbsp;using&nbsp;any&nbsp;public&nbsp;cloud&nbsp;platform&nbsp;(e.g.,&nbsp;AWS,&nbsp;GCP,&nbsp;Azure)</li><li>Experience&nbsp;with&nbsp;data&nbsp;pipelines&nbsp;or&nbsp;ML&nbsp;frameworks&nbsp;(e.g.,&nbsp;TensorFlow,&nbsp;Spark)</li><li>Certification&nbsp;in&nbsp;Kubernetes&nbsp;(Certified&nbsp;Kubernetes&nbsp;Application&nbsp;Developer&nbsp;-&nbsp;CKAD)</li><li>Comfortable&nbsp;working&nbsp;on&nbsp;WordPress&nbsp;and&nbsp;CMS&nbsp;platforms&nbsp;like&nbsp;Statamic&nbsp;or&nbsp;Ghost</li></ul><p>&nbsp;</p>
EOD,
            ],
            [
                'company_id'             => $companies['tyrell-corp'] ?? null,
                'role'                   => 'Full Stack Developer',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 2,
                'active'                 => 1,
                'post_date'              => '2025-10-24',
                'apply_date'             => '2025-10-24',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Los Angeles',
                'state_id'               => 5,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 1,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 1,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://job-boards.greenhouse.io/sensiblecare/jobs/4606959006?gh_src=pqasv41x6us',
                'link_name'              => null,
                'description'            => <<<EOD
<h2>Full Stack Developer</h2><p>California</p><h4><strong>About the Role:</strong>&nbsp;</h4><h4>Sensible Care is hiring a full-stack developer who will help us build and maintain our tele-therapy platform and native mobile applications. The ideal candidate will be a team player excited to join a group of like-minded, talented people who are inclusive, respectful, and thoughtful and who value fresh ideas and want to tackle hard problems. If improving and enhancing the experience and access of our highly sought-after Behavioral Health Services sounds exciting and rewarding, we would love to talk to you!&nbsp;</h4><h4>Our current tech stack uses Laravel (PHP) for the back end with a Postgres database. We use Vue for the front end on the web and Flutter for iOS and Android. While this post is for a mid-level developer, we are open to hiring at other levels for the right candidate.&nbsp;</h4><h4><strong>Who You Are:</strong>&nbsp;</h4><p><strong>A Craftsperson</strong>: You enjoy and take pride in all aspects of your projects from conception to solution and get as much satisfaction from continually improving something as you do from starting something new.&nbsp;</p><p><strong>Autonomous</strong>: You’re able to take a set of project requirements — or even a well-described idea— and turn it into a working product without much assistance.&nbsp;</p><p><strong>Curious</strong>: You interested in branching out to other areas (devops/cloud engineering? AI/ML? UI/UX? etc.) and value the opportunity to do so.&nbsp;</p><p><strong>Fearless</strong>: You’re not intimidated by challenges and welcome the opportunity to participate in all phases of software development as needed.&nbsp;</p><p><strong>Team Player</strong>: You’re comfortable working cross-functionally with different teams and departments (both technical and non-technical).&nbsp;</p><p><strong>What You’ll Do:</strong>&nbsp;</p><p>The key responsibility of this position is to develop end-to-end solutions for our clients and for internal use. You will be working with a small group of developers and project leaders and join the team that is tasked with building and improving the systems that will support our continued growth and nationwide expansion. If you\'re on the fence or unsure if you’ll meet the requirements, please apply if you can:&nbsp;</p><ul><li>Write front-end and back-end code have a solid grasp of coding best practices&nbsp;</li><li>Use a framework to create performant, reliable HTTP-based APIs (such as Laravel).&nbsp;</li><li>Wire APIs to a modern front-end framework (we use Vue.js)&nbsp;</li><li>Employ third-party libraries and SDKs to extend the capabilities of first-party applications.&nbsp;</li><li>Write unit, integration, and end-to-end tests, and understand the importance of testing.&nbsp;</li><li>Deploy, monitor, and troubleshoot your systems in staging and production environments.&nbsp;</li></ul><p><strong>What You Need:</strong>&nbsp;</p><ul><li>3+ years of hands-on, production-level software development experience, preferably with some or all of our tech stack&nbsp;</li><li>Experience with Flutter, and especially with Flutter bloc.&nbsp;</li><li>Familiarity with git and understanding of the basics of CI/CD&nbsp;</li><li>Good verbal and written communications skills&nbsp;</li><li>A willingness to take initiative and ownership in a small-company environment&nbsp;</li><li>The ability to work remotely in an efficient manner&nbsp;</li><li>Healthcare or HealthTech industry experience is a plus, but not required&nbsp;</li></ul><p><strong>What We Offer:</strong>&nbsp;</p><ul><li>Excellent compensation including competitive salary + bonus&nbsp;&nbsp;</li><li>401(k) account with contribution matching&nbsp;</li><li>Gym membership stipend&nbsp;</li><li>15 vacation days, 5 sick days, and paid holidays annually&nbsp;</li><li>Health, Dental, and Vision coverage for you and your family&nbsp;</li></ul><p><strong>Let’s stay in touch!</strong></p><p>Follow us on LinkedIn (Sensible Care) and Instagram (@sensiblecarementalhealth)</p><p>&nbsp;</p><p><i>Sensible Care is committed to serving our clients and empowering our providers and the multitude of teams who support our providers. We offer competitive compensation, excellent benefits, work + life balance, and a collaborative, empowering culture committed to providing the highest quality mental healthcare and being the employer of choice.</i></p><p><i>At Sensible Care, we embrace diversity, empowerment, invest in a culture of inclusion, positivity and encourage all to apply to join our supportive team. All qualified applicants will receive consideration for employment without regard to race, color, religion, gender, gender identity or expression, sexual orientation, national origin, genetics, disability, age, or veteran status.</i></p>
EOD,
            ],
            [
                'company_id'             => $companies['initech'] ?? null,
                'role'                   => 'PHP and Python #jn04',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-php-developer-[prettified]'] ?? null,
                'rating'                 => 2,
                'active'                 => 1,
                'post_date'              => '2025-11-21',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 100000,
                'compensation_max'       => 150000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Austin',
                'state_id'               => 44,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 1,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.linkedin.com/jobs/search-results/?currentJobId=4337606295&eBP=NOT_ELIGIBLE_FOR_CHARGING&keywords=laravel%20remote&origin=JOBS_HOME_SEARCH_BUTTON&refId=IFQudPJT%2FBuRuqiWFxAwDw%3D%3D&trackingId=mZqJnHNcfnoU%2FTOIs9P%2FVg%3D%3D',
                'link_name'              => 'LinkedIn',
                'description'            => <<<EOD
<figure class=\"image\"><img src=\"https://media.licdn.com/dms/image/v2/D4E0BAQHiKb26Fwpe2Q/company-logo_100_100/company-logo_100_100/0/1707015599885?e=1765411200&amp;v=beta&amp;t=Y2mOyyxyhyKjvJZcPq6b6eCvS1Bw3IYzSC71PJbB3ZE\" alt=\"OPENDataJobs logo\"></figure><p><a href=\"https://www.linkedin.com/company/opendatajobs/life\"><strong>OPENDataJobs</strong></a></p><p><strong>Share</strong></p><p><strong>Show more options</strong></p><h2><a href=\"https://www.linkedin.com/jobs/view/4337606295/?alternateChannel=search&amp;eBP=NOT_ELIGIBLE_FOR_CHARGING&amp;refId=IFQudPJT%2FBuRuqiWFxAwDw%3D%3D&amp;trackingId=mZqJnHNcfnoU%2FTOIs9P%2FVg%3D%3D\"><strong>Full Stack Developer - PHP and Python #jn04</strong></a></h2><p>Washington, DC · 3 days ago · 58 applicants</p><p>No response insights available yet</p><p><strong>$100K/yr - $150K/yr RemoteMatches your job preferences, workplace type is Remote. Full-timeMatches your job preferences, job type is Full-time.</strong></p><p><strong>Easy Apply</strong></p><p><strong>SaveSave Full Stack Developer - PHP and Python #jn04 at OPENDataJobs</strong></p><h2><a href=\"https://www.linkedin.com/jobs/view/4337606295/?alternateChannel=search&amp;refId=IFQudPJT%2FBuRuqiWFxAwDw%3D%3D&amp;trackingId=mZqJnHNcfnoU%2FTOIs9P%2FVg%3D%3D\"><strong>Full Stack Developer - PHP and Python #jn04</strong></a></h2><p>OPENDataJobs · Washington, DC (Remote)</p><p><strong>Easy Apply</strong></p><p><strong>SaveSave Full Stack Developer - PHP and Python #jn04 at OPENDataJobs</strong></p><p><strong>Show more options</strong></p><p>&nbsp;</p><h2><strong>Job match is medium, review match details</strong></h2><h3>Your profile matches several of the required qualifications</h3><p>&nbsp;</p><ul><li><strong>Show match details</strong></li><li><strong>Tailor my resume</strong></li><li><strong>Practice an interview</strong></li><li><strong>Create cover letter</strong></li></ul><p>BETA</p><p>Is this information helpful?</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>About the job</strong></h2><p>Peregrine Advisors Benefit Inc. seeks a technically skilled Full Stack Developer to join a high-impact team of Data Scientists, Data Specialists, DevSecOps Engineers, and Developers to deliver on innovative and transformative initiatives. This position focuses on developing modern web applications through PHP/Laravel development, Python scripting, and responsive frontend technologies. Work involves building scalable web applications, creating intuitive user interfaces, developing APIs, and managing web application data processing.<br><br>The ideal candidate will build systems that solve critical organizational problems by creating engaging user experiences to drive data use and data-driven insights, implementing robust backend systems, and establishing testing frameworks for web applications. Responsibilities include developing interactive visualizations and dashboards, building content management systems, and optimizing application performance. This position requires a proactive individual capable of intimately understanding client problems, working across the entire web development stack, and driving innovation at the enterprise level through web application development.<br><br>Formed as a public benefit corporation, Peregrine is committed to creating social value through all our business activities. We are highly selective, seeking strong candidates who can perform effectively across a variety of roles and clients, and who bring a sincere drive to create positive social impact through solving challenging problems. If you thrive on solving challenging problems, are a self-starter with excellent communication skills, and have a strong desire to learn and make the world better, we encourage you to apply.<br><br><strong>Responsibilities</strong><br><br>&nbsp;</p><ul><li>Build Modern Web Applications: Design and develop full stack web applications using PHP/Laravel framework, creating scalable architectures able to serve large numbers of concurrent users</li><li>Frontend Development: Create responsive and interactive user interfaces using modern JavaScript, CSS frameworks, and popular frontend libraries</li><li>API Development: Build robust RESTful APIs and web services to enable seamless data exchange between applications and third-party integrations</li><li>Database Integration: Design and implement database integrations for web applications, ensuring efficient data storage and retrieval</li><li>Python Automation: Develop Python scripts for data processing, web scraping, APIs, and other automated tasks to enhance application functionality</li><li>AWS Deployment: Deploy and manage web applications in AWS environments using EC2, RDS, S3, and CloudFront for scalable hosting</li><li>Performance Optimization: Analyze and optimize web application performance, implementing caching strategies and efficient loading techniques</li><li>Test Implementation: Create comprehensive test suites including unit tests and integration tests to ensure application quality<br><br>&nbsp;</li></ul><p><strong>Requirements</strong><br><br><strong>Core Technologies:</strong><br><br>&nbsp;</p><ul><li>Expert-level proficiency in PHP and Laravel framework with MVC architecture and Eloquent ORM</li><li>Strong skills in HTML5, CSS3, modern JavaScript (ES6+), and at least one frontend framework (React, Vue.js, or Angular)</li><li>Solid Python programming skills for scripting, automation, and web development frameworks (Django, Flask, or FastAPI)</li><li>Experience with relational databases (such as MySQL, PostgreSQL) and data optimization for web applications<br><br>&nbsp;</li></ul><p><strong>AWS and Development Tools:</strong><br><br>&nbsp;</p><ul><li>Experience with AWS services for web application deployment (EC2, RDS, S3, CloudFront, Route 53)</li><li>Proficiency with Git version control, modern IDEs, package managers (Composer, npm/yarn), and debugging tools</li><li>Understanding of HTTP protocols, web security principles, API design, and responsive design frameworks<br><br>&nbsp;</li></ul><p><strong>Professional Skills:</strong><br><br>&nbsp;</p><ul><li>5+ years of professional development and / or software engineering experience with PHP/Laravel and Python</li><li>Strong analytical and troubleshooting abilities for complex web application issues</li><li>Excellent communication and collaboration skills for working with cross-functional teams<br><br>&nbsp;</li></ul><p><strong>Bonus Qualifications:</strong><br><br>&nbsp;</p><ul><li>LLM System Implementation: Experience integrating Large Language Model APIs (OpenAI, Anthropic), prompt engineering, vector databases, and building AI-assisted applications or chatbots</li><li>Blockchain Implementation: Understanding of blockchain technology, smart contract integration, Web3 technologies, and decentralized applications<br><br>&nbsp;</li></ul><p><strong>Education and Experience:</strong><br><br>&nbsp;</p><ul><li>Bachelor\'s degree in Computer Science, Web Development, Software Engineering, or related field</li><li>Strong portfolio showcasing full stack development projects</li><li>U.S. citizenship and ability to obtain Public Trust clearance</li><li>Preference for candidates in the greater Washington, DC area for hybrid work<br><br>&nbsp;</li></ul><p><strong>Benefits</strong><br><br><strong>Peregrine Culture &amp; Values</strong>: At Peregrine Advisors, we are deeply committed to creating social value and improving government performance through data-driven solutions. We hire individuals who are not only skilled but also eager to contribute to a positive social impact. Our inclusive work environment encourages collaboration and innovation, providing employees with the opportunity to grow and develop professionally.<br><br><strong>Growth &amp; Development Opportunities</strong>: We provide extensive onboarding support, professional development opportunities, and sponsored training programs to help our employees excel. Our team members work on high-impact projects with some of the largest datasets in the federal sector, offering both technical challenges and opportunities for growth.<br><br><strong>Benefits</strong>: Peregrine Advisors offers a comprehensive and competitive benefits package, including:<br><br>&nbsp;</p><ul><li>Full health coverage (medical, dental, and vision) with 100% of employee premiums covered</li><li>Life and disability insurance, fully covered by the company</li><li>401(k) retirement plan with 100% match on contributions up to 4% of salary, with immediate vesting</li><li>Unlimited Paid Time Off (PTO) to encourage work-life balance</li><li>Tuition reimbursement for further education and professional development<br><br>&nbsp;</li></ul><p>Peregrine Advisors is an equal opportunity employer, welcoming diversity and inclusivity in all hiring practices. We do not discriminate based on race, religion, gender, sexual orientation, age, marital status, veteran status, or disability status.</p><p>&nbsp;</p><h3><strong>Benefits found in job post</strong></h3><p>&nbsp;</p><ul><li>Disability insurance</li><li>401(k)</li></ul>
EOD,
            ],
            [
                'company_id'             => $companies['wayne-enterprises'] ?? null,
                'role'                   => 'Senior Software Engineer',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 3,
                'active'                 => 1,
                'post_date'              => '2025-10-24',
                'apply_date'             => '2025-10-24',
                'close_date'             => null,
                'compensation_min'       => 135000,
                'compensation_max'       => 160000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Gotham City',
                'state_id'               => 33,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 1,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 1,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://workforcenow.adp.com/mascsr/default/mdf/recruitment/recruitment.html?cid=2b3ab744-79ef-4eef-b58e-b409f2ddadb6&ccId=19000101_000001&lang=en_US&jobId=984424&source=LI',
                'link_name'              => null,
                'description'            => <<<EOD
<h2>Senior Software Engineer</h2><p>Full Time RegularStaff - Exempt</p><p>Cincinnati, OH, US</p><p><i>30+ days ago</i>Requisition ID: 1359</p><p>Apply</p><p>&nbsp;</p><p><strong>Precision eControl (PeC) is a wholly owned ancillary business of Vorys, that provides integrated solutions to help brands control the sales of their products in the age of eCommerce. We have represented more than 300 brands, including many of the world’s largest companies. PeC’s full scope of services allows us to provide a truly comprehensive approach that delivers unique business value. &nbsp;</strong></p><p><strong>Position Summary:</strong></p><p>The Senior Software Engineer (Front-End) will design, develop, and implement software solutions utilizing Laravel, TailwindCSS, HTML, SQL, and JavaScript. This position is responsible for developing backend and frontend components, database schemas and models, writing/maintaining tests, creating/maintaining deployment pipelines and environments, and responding to support issues and production bugs/outages.&nbsp;<i><strong>At this time, candidates who would work in the following states will not be considered for this role: AZ, CA, CO, CT, DE, DC, HI, IL, MA, ME, MI, MD, MN, NV, NJ, NY, RI, VT, and WA.</strong></i></p><p><strong>Essential Functions:</strong></p><ul><li>Develop and maintain front-end applications using Vue, Tailwind CSS, JavaScript, Filament, and related technologies.</li><li>Develop and maintain Laravel applications using PHP, Laravel, SQL, and related technologies.</li><li>Write and maintain unit tests and automated click tests.</li><li>Maintain and develop components for a shared design component library.</li><li>Participate in sprint ceremonies, collaborate with product and design.&nbsp;</li><li>Debug and troubleshoot issues, including production support, across the backend, frontend, and database components of the application.&nbsp;</li><li>Perform code reviews, provide feedback to other engineers, and ensure the quality of the codebase.</li><li>Maintain CI/CD pipelines, infrastructure, and databases.</li></ul><p><strong>Knowledge, Skills and Abilities Required:</strong></p><ul><li>5+ years of experience with Vue (or similar frameworks such as React or Svelte)</li><li>3+ years of experience integrating back-end business applications with front-end, preferably PHP/Laravel</li><li>Experience developing and maintaining frontend component libraries and working with Product/Design on UX</li><li>Experience performing code reviews and providing feedback/mentorship to fellow engineers</li><li>Experience debugging frontend and backend issues</li><li>Ability to collaborate closely with cross-functional teams, including designers and product managers</li><li>Ability to turn designs into responsive frontend code</li><li>Demonstrated knowledge of accessibility best practices</li></ul><p><strong>Desirable But Not Essential:</strong></p><ul><li>Experience building/maintaining design systems</li><li>Experience with TailwindCSS</li></ul><p><strong>Education and Experience:</strong></p><ul><li>Bachelor\'s degree in related discipline or combination of equivalent education and experience.</li><li>Bachelor’s degree in computer science preferred.</li><li>5 - 7 years of experience in similar field.</li></ul><p>The expected pay scale for this position is $135,000.00- $160,000.00 and represents our good faith estimate of the starting rate of pay at the time of posting. The actual compensation offered will depend on factors such as your qualifications, relevant experience, education, work location, and market conditions.</p><p>At PeC, we are dedicated to fostering a workplace where employees can succeed both personally and professionally. We offer competitive compensation along with a robust benefits package designed to support your health, well-being, and long-term goals. Our benefits include medical, dental, vision, FSA, life and disability coverage, paid maternity &amp; parental leave, discretionary bonus opportunity, family building resources, identity theft protection, a 401(k) plan with discretionary employer contribution potential, and paid sick, personal and vacation time. Some benefits are provided automatically, while others may be available for voluntary enrollment. You’ll also have access to opportunities for professional growth, work-life balance, and programs that recognize and celebrate your contributions.</p><p><strong>Equal Opportunity Employer:</strong></p><p>PeC does not discriminate in hiring or terms and conditions of employment because of an individual’s sex (including pregnancy, childbirth, and related medical conditions), race, age, religion, national origin, ancestry, color, sexual orientation, gender identity, gender expression, genetic information, marital status, military/veteran status, disability, or any other characteristic protected by local, state or federal law. PeC only hires individuals authorized for employment in the United States.&nbsp;</p><p>PeC is committed to providing reasonable accommodations to qualified individuals in our employment application process unless doing so would constitute an undue hardship. If you need assistance or an accommodation in our employment application process due to a disability; due to a limitation related to, affected by, or arising out of pregnancy, childbirth, or related medical conditions; or due to a sincerely held religious belief, practice, or observance, please contact Julie McDonald, CHRO. Our policy regarding requests for reasonable accommodation applies to all aspects of the hiring process.</p><p>&nbsp;</p><p>&nbsp;</p><p><i>#LI-Remote</i></p>
EOD,
            ],
            [
                'company_id'             => $companies['virtucon'] ?? null,
                'role'                   => 'Senior Software Engineer (Influencer)',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => null,
                'apply_date'             => null,
                'close_date'             => null,
                'compensation_min'       => 184000,
                'compensation_max'       => 184000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Durham',
                'state_id'               => 34,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://ats.rippling.com/teamworks-careers/jobs/13d6c052-10a0-46ad-938f-c85546d78a94?jobSite=LinkedIn',
                'link_name'              => 'LinkedIn',
                'description'            => <<<EOD
<h2>Senior Software Engineer (Influencer)</h2><p>Teamworks, the Operating System for Sports™, powers more than 6,500 sports organizations worldwide, including collegiate athletic departments and teams across all major professional leagues. With almost 500 exceptional employees located in over a dozen different countries, Teamworks’ software solutions drive the operations of the most recognizable sports properties in the world.</p><p>&nbsp;</p><p>We are seeking a Senior Software Engineer to join our Personnel product engineering team, where you\'ll focus on building the future of NIL (Name, Image, Likeness) management through our Influencer product. Influencer empowers athletic departments, compliance teams, and student-athletes to navigate the evolving landscape of NIL partnerships, contracts, and monetization opportunities while maintaining compliance and transparency. You\'ll work on mission-critical systems that connect athletes with brands, manage contracts and payments, and integrate with our broader Personnel ecosystem, including General Manager, Contracting, and Wallet—a high-impact opportunity to contribute across multiple products, architect scalable solutions, and help shape the technical foundation of how college athletics manages modern athlete compensation.</p><p>&nbsp;</p><p>This is an exciting opportunity to help shape the future of athlete performance management in one of the fastest-growing companies in sports tech.</p><p>&nbsp;</p><h4><strong>Game Plan - How You\'ll Drive Impact:</strong></h4><ul><li>Build and maintain Laravel-based microservices that power contract management, payment processing, and compliance tracking</li><li>Architect and implement event-driven integrations across multiple Teamworks products (General Manager, Wallet, Compliance) using Pub/Sub patterns and asynchronous messaging</li><li>Develop well-documented APIs and backend services that enable seamless data flow between Personnel products and external NIL platforms</li><li>Lead technical decision-making around data model design, service orchestration, and system interoperability across a complex microservices ecosystem</li><li>Optimize SQL queries and database performance to support high-volume transaction processing and reporting requirements</li><li>Participate in implementation planning and architectural discussions, contributing ideas and helping define technical direction</li><li>Conduct thorough code reviews and provide mentorship to fellow engineers, fostering a culture of quality and continuous improvement</li></ul><h4><strong>Player Profile - What You Bring to the Team:</strong></h4><ul><li>Expert-level experience with PHP and Laravel, with a strong track record of building Laravel applications that scale beyond boilerplate implementations</li><li>Deep understanding of Laravel conventions, Eloquent ORM, service container usage, middleware patterns, and the broader Laravel ecosystem (queues, jobs, events, service providers)</li><li>Strong SQL skills with the ability to write, optimize, and debug complex queries in MySQL or other relational databases</li><li>Experience building and integrating microservices across multiple applications, with a solid grasp of service-oriented architecture principles</li><li>Hands-on experience with event-driven architecture, including Pub/Sub systems, message queues, and asynchronous processing (AWS SQS, RabbitMQ, Kafka, or similar)</li><li>Ability to design and consume HTTP APIs for internal service-to-service communication</li><li>Experience conducting constructive code reviews that help elevate team standards while maintaining a positive, collaborative tone</li><li>Familiarity with version control, CI/CD workflows, and containerized environments (e.g., Docker)</li></ul><h4><strong>The Ideal Recruit - Skills &amp; Experience:</strong></h4><ul><li>Bachelor\'s or Master\'s degree in Computer Science, Software Engineering, or a related field.</li><li>Experience with enterprise-grade queuing and messaging systems beyond framework-specific implementations</li><li>Familiarity with front-end technologies such as Filament and Inerita.js for admin interfaces</li><li>Background working with financial systems, payment processing, or contract management workflows</li><li>Experience with cloud platforms (AWS, Azure, GCP) and infrastructure-as-code tools</li></ul><h4><strong>Champion Mindset - Traits for Success:</strong></h4><ul><li>Self-sufficient and proactive—able to architect solutions, lead initiatives, and make technical decisions with confidence</li><li>Strong communication skills with the ability to provide feedback tactfully and collaborate effectively across remote teams and time zones</li><li>Willingness to mentor and support other engineers through informal coaching, plan vetting, and thoughtful guidance</li><li>Ability to balance multiple priorities and navigate context switching between products without losing momentum</li><li>Creative problem-solver who can identify technical constraints and opportunities, then develop pragmatic solutions</li><li>Strong product thinking with user empathy and an understanding of how complex systems work together</li><li>Pragmatic focus on ROI and the ability to estimate, prioritize, and deliver high-impact work</li><li>Aligned with our core values: honesty, humility, hard work, commitment, innovation, and exceptionalism</li></ul><h4><strong>The Perks of Playing for Teamworks:</strong></h4><p>At Teamworks, you’re not just joining a company—you’re joining a team that’s shaping the future of sports. We believe that success starts with investing in our people, and here’s how we support and reward every teammate:</p><ul><li><strong>Play to Win:</strong> Grow your career as we grow. Shape the future of sports technology while building a career that scales with your ambition.</li><li><strong>Winning Culture:</strong> Join a global team of high achievers, innovators, and problem solvers who value teamwork and humility.</li><li><strong>Competitive Compensation:</strong> Earn a competitive salary, performance-based incentives, and equity so you share in our success.</li><li><strong>Comprehensive Benefits:</strong> Access region-specific benefits designed to support your well-being, including health coverage, life and disability insurance, retirement plans, unlimited paid time off, flexible and remote work options, catered lunches (where applicable), and more.</li><li><strong>Investing in Your Growth:</strong> Receive stipends for learning and development, home office equipment, and company gear to set you up for success—no matter where you are in the world.</li></ul><h3><strong>Compensation Philosophy:</strong></h3><p>For this role, the salary target is <strong>$180,430/C$193,319</strong>, with your final offer determined by your experience, skills, and interview performance. Every Teamworks teammate is an owner, with equity aligning your success with ours.</p><p>&nbsp;</p><p>We’ve built our compensation framework to attract, retain, and reward top performers. We believe in pay for performance, ensuring that your growth and impact are reflected in your rewards. As Teamworks grows, so do your opportunities—whether that’s through advancing your career, contributing to game-changing innovations, or building long-term financial security.</p><p>&nbsp;</p><p>We continuously review and refine our compensation practices to ensure fairness and alignment with both company goals and individual aspirations. We encourage open discussions about career growth and compensation, and your hiring manager is always available to answer your questions.</p><p>&nbsp;</p><p>At Teamworks, we’re committed to supporting you in and out of the game—empowering you to do your best work while enjoying meaningful rewards.</p><h4><strong>Inside our Locker Room:</strong></h4><p>Teamworks is the leading operating system for elite sports, empowering organizations worldwide to optimize performance, streamline operations, and unlock athlete potential. Founded in 2006, we’ve grown from a messaging platform for collegiate football into a global leader with over $165 million in funding and a technology suite that supports every phase of the athlete lifecycle.</p><p>&nbsp;</p><p>Our solutions span four key categories:</p><ul><li><a href=\"https://teamworks.com/personnel/\"><strong>Personnel</strong></a><strong>:</strong> Manage the complete roster lifecycle, from recruiting and NIL management to financial operations.</li><li><a href=\"https://teamworks.com/performance/\"><strong>Performance</strong></a><strong>:</strong> Optimize athlete health and training with advanced tools for nutrition, strength &amp; conditioning, and holistic performance tracking.</li><li><a href=\"https://teamworks.com/operations/\"><strong>Operations:</strong></a> Streamline logistics, communication, compliance, and inventory management to keep teams running efficiently.</li><li><a href=\"https://teamworks.com/intelligence/\"><strong>Intelligence</strong></a><strong>:</strong> Leverage data-driven insights to inform decisions and maximize competitive advantage across professional and collegiate sports.</li></ul><p>At Teamworks, we’re driven by innovation and a passion for sports. We serve more than 6,500 sports organizations globally, helping teams achieve excellence on and off the field. Join us and be part of the future of sports technology.</p><p>&nbsp;</p><p>Our offices are open for work, collaboration, and optional team-building events – but as a remote-first company, we also have teammates working from places across the globe, including New York, London, Perth, and Austin.</p><h3><strong>What to Expect When Interviewing at Teamworks</strong></h3><p>Our interview process is designed to be transparent, engaging, and reflective of our team culture. You can expect authentic conversations, clear steps, and the opportunity to connect with key team members. We encourage you to ask questions and get to know us as much as we get to know you.</p><p>Learn more about our process <a href=\"https://teamworks.com/blog/interviewing-with-teamworks/\">here</a>.</p><p>&nbsp;</p><p><strong>Teamworks is an equal opportunity employer - if you live our core values every day and are honest, hardworking, humble, committed, innovative, and an all-around exceptional person, you\'ll thrive at Teamworks. We are committed to building a diverse and inclusive workforce and take affirmative action to not discriminate based on race, religion, color, national origin, ancestry, physical disability, mental disability, medical condition, genetic information, marital status, sex, gender, gender identity, gender expression, age, sexual orientation, veteran or military status, or any other legally protected characteristics. &nbsp;This policy applies to all employment practices within our organization, including but not limited to recruiting, hiring, promotion, termination, compensation, benefits, and training.&nbsp;Teamworks is committed to providing reasonable accommodations for candidates with disabilities who need assistance during the hiring process. To request a reasonable accommodation, please email hiring@teamworks.com.</strong></p><p>&nbsp;</p><p><i><strong>To all recruitment agencies: Teamworks does not accept agency resumes. Please do not forward resumes to our jobs alias, Teamwork employees or any other organization location. Teamworks is not responsible for any fees related to unsolicited resumes.</strong></i></p><p>The pay range for this role is:</p><p>180,430 - 180,430 USD per year (Remote (United States))</p><p>193,319 - 193,319 CAD per year (Remote (Canada))</p>
EOD,
            ],
            [
                'company_id'             => $companies['globex'] ?? null,
                'role'                   => 'Developer Relations Community Manager',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 0,
                'post_date'              => '2025-11-17',
                'apply_date'             => '2025-11-24',
                'close_date'             => '2025-11-25',
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 1,
                'vacation'               => 1,
                'health'                 => 1,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://apply.workable.com/laravel/j/206D7866F1/',
                'link_name'              => null,
                'description'            => <<<EOD
<h2><strong>Developer Relations Community Manager</strong></h2><p><strong>Remote</strong>MarketingFull time</p><p>United States</p><p>Canada</p><p>Argentina</p><p>Brazil</p><p>Mexico</p><p>New Zealand</p><p><a href=\"https://apply.workable.com/laravel/j/206D7866F1/\"><strong>Overview</strong></a><a href=\"https://apply.workable.com/laravel/j/206D7866F1/apply/\"><strong>Application</strong></a></p><p>&nbsp;</p><h2><strong>Description</strong></h2><p>At Laravel, we are committed to creating tools that empower developers to build exceptional web applications while nurturing a supportive and inclusive global community. By joining our team, you’ll play a pivotal role in helping developers succeed and thrive in their work.<br><br>Community Management at Laravel is responsible for engaging with our online communities across X, Reddit, Discord, and other channels. You’ll be on the front line for assisting Laravel developers, communicating the value of Laravel Cloud, and serving as our insight into the community at large. You’ll also partner with Dev Rel and Marketing to distribute and create content.</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>Requirements</strong></h2><p>&nbsp;</p><p><strong>Engage the Community →</strong> We have large online communities in Discord, Reddit, and X.</p><p><strong>Be a Resource →</strong> help Community members find what they need to succeed with Laravel products.</p><p><strong>Bring Feedback →</strong> Ensure our Product teams are hearing from the Community.</p><p>&nbsp;</p><p>This role requires working within +/- 3 hours of Pacific Standard Time.</p><p>&nbsp;</p><p>&nbsp;</p><p>Minimum Requirements</p><ul><li>3+ years of relevant work experience in Laravel in engineering, DevRel, marketing, or support.</li><li>Excellent verbal and written communication skills, with experience translating technical features into benefits for a technical audience</li></ul><p>&nbsp;</p><p>We’re looking for someone who meets the minimum requirements to be considered for the role. If you meet these requirements, you are encouraged to apply.</p><h2><strong>Benefits</strong></h2><ul><li>Fully remote and globally distributed working environment</li><li>Option to attend Laracon conferences around the world</li><li>Paid time off (Vacation, Sick &amp; Public holidays)</li><li>Family leave (Maternity, Paternity)</li><li>Company equity</li><li>Welcome kit with custom Laravel swag</li></ul>
EOD,
            ],
            [
                'company_id'             => $companies['umbrella-corp'] ?? null,
                'role'                   => 'Engineering Team Lead - CDP / DMP',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 125000,
                'compensation_max'       => 150000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://purecars.hire.trakstar.com/jobs/fk0p963?pjb_hash=Y7bAmjMPq4',
                'link_name'              => null,
                'description'            => <<<EOD
<p>Engineering Team Lead - CDP / DMP</p><p>United States | Full-time | Fully remote</p><p>&nbsp;</p><p><strong>Who is PureCars?</strong></p><p>As the industry leader in automotive marketing, we’re trusted by the best dealers in North America. From innovative solutions to support from trusted experts, making marketing easier is our job. PureCars provides everything dealers need to attract and convert more customers with tech-driven solutions, unmatched data capabilities, and direct access to support.</p><p>We are a certified digital provider for 20+ OEM programs and compliant with over 40 brands. We also serve 65 of the top 100 dealer groups in North America. We are proud to partner with leading organizations such as Google, Meta, Amazon, Spotify, Disney+, Microsoft, Oracle, and others to offer the widest range of advertising channels to our dealership clients.</p><p>We are focused on investing in world-class talent and technology in order to help our partners dominate their markets in new and innovative ways.</p><p><strong>Title:</strong> Engineering Team Lead</p><p><strong>Reports To:</strong> VP, Engineering</p><p><strong>Job Summary - Engineering Team Lead - CDP / DMP</strong></p><p>In this role a candidate will lead their full stack development team in both a technical and managerial capacity; with the time split at 70% technical and 30% management/leadership support tasks. This role will work in an AWS developing and maintaining a multi-tenant CDP and CLM system, built primarily on PHP/Laravel with an emphasis on continuous delivery, safety and correctness.</p><p><strong>Primary Responsibilities:</strong></p><ul><li>Lead a full stack development team, monitor team performance and unblock team members as needed.</li><li>Provide mentorship and take a genuine interest in the success and professional development of your team.</li><li>Passionately architect, code, and advocate for scalability, reliability, maintainability and reusability.</li><li>Take accountability for all aspects of the Company\'s software owned by your team.</li><li>Help develop and refine processes to enhance quality and productivity for the team including best practices, testing and code reviews.</li><li>Working closely with product owners, lead the development of product roadmaps and facilitate team meetings for agile development processes.</li><li>Assist in the definition, development and documentation of software’s business requirements, objectives, deliverables and specifications on a project-by-project basis in collaboration with internal users and departments.</li><li>Cooperate with the QA team to define test cases, metrics and resolution guidelines.</li><li>Cooperate with other engineering teams to facilitate design, testing, and implementation of cross-cutting projects.</li><li>Participate in peer reviews of solution designs and related code.</li><li>Prioritize management of technical debt.</li></ul><p><strong>Requirements:</strong></p><ul><li>5+ years of recent &amp; relevant development experience.<ul><li>Backend: PHP, Laravel</li><li>Frontend: Vue</li></ul></li><li>Demonstrated senior-level knowledge with Object Oriented Programming, Design Patterns, Service Oriented Architecture.</li><li>Exceptional communication, problem solving and analytical skills.</li><li>Experience with agile methodologies.</li><li>A strong desire for continual personal, professional and technical improvement.</li></ul><p><strong>Nice-To-Haves:</strong></p><ul><li>Experience with backend systems development using .NET 5.0+.</li><li>Experience with frontend development using React and TypeScript.</li><li>Cloud Native development experience: Kubernetes, Azure, AWS.</li><li>Prior leadership experience.</li><li>Experience with designing and implementing service-oriented architectures.</li></ul><p>Salary Range: $125,000.00 - $150,000.00</p><p><i>PureCars is committed to building diverse teams and upholding an equal employment workplace that is free from discrimination. We hire amazing individuals regardless of their race, color, ancestry, religion, sex, gender identity, national origin, sexual orientation, age, citizenship, marital status, pregnancy, medical conditions, genetic information, disability, or Veteran status. Just be passionate, genuine, collaborative, data-driven, and entrepreneurial at heart!</i></p>
EOD,
            ],
            [
                'company_id'             => $companies['stark-industries'] ?? null,
                'role'                   => 'Software Developer– Orlando FL',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-10',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 80000,
                'compensation_max'       => 110000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 1,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 4,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Orlando',
                'state_id'               => 10,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.linkedin.com/jobs/search-results/?currentJobId=4250047005',
                'link_name'              => null,
                'description'            => <<<EOD
<figure class=\"image\"><img src=\"https://media.licdn.com/dms/image/v2/C4D0BAQG-FDlPOmxlbA/company-logo_100_100/company-logo_100_100/0/1631350616023?e=1765411200&amp;v=beta&amp;t=A7oUTbZ0SMl1-aGMARAw2pVxIu6xBNt_9yYhoOnvXAk\" alt=\"Cogent Communications logo\"></figure><p><a href=\"https://www.linkedin.com/company/cogent-communications/life\"><strong>Cogent Communications</strong></a></p><p><strong>Share</strong></p><p><strong>Show more options</strong></p><h2><a href=\"https://www.linkedin.com/jobs/view/4250047005/?alternateChannel=search&amp;eBP=CwEAAAGauCpPyxrKrQbNPN673ldCU0EPSh8DLTQWR4hFuOy4XA0yCia29sngtw6zwRPVsbsQM8FnokF-ABraIWYuki1LdZIYS7k-6h-_xOAnU8iCJVKLdHG8hFo9NuYnbUGZYSoEq3SBhalx9cRxoq-W6bmxdMITXFNd1OlUyQWIIqHE0LVDP0IDwNBrdvuBxqI8O5YFB_ctq-KO4TeksODAzYsKa1XVuvBDcnXg_XIp9hsxkBHt4Ln-ZRIcSr1CC0pml1m6sTd-xJVanLaE_kBdelEdtG7Qq7AI1ed0hKh28eeR65j3kZcwz24pIgTfBuDVX-YZAEI4DfwXem5J_L8rKeVJt8P9xqsUEWLEJnmQ9r0nZrXWGoj07dg4MOsCQPe6N2R5Lnw4SNKKddON8PeRplnd2r13xYAjjcPwsbgvwUpo5f28YYr5waXKYupsHh_aXB18zxQ3uiLsEyTg0vPJaDfZ6t16Rsj0Q1LXiK0UobF8y8zim6Omco499ftzcQ&amp;refId=L9W2R9s23MesKiozuuv3UQ%3D%3D&amp;trackingId=QJuG2ZUcVt2wN5I%2BG%2B6fMw%3D%3D\"><strong>Software Developer– Orlando FL</strong></a></h2><p>&nbsp;</p><p>&nbsp;</p><p>Orlando, FL · Reposted 2 weeks ago · Over 100 applicants</p><p>Promoted by hirer · <strong>Actively reviewing applicants</strong></p><p><strong>$80K/yr - $110K/yrOn-site Full-timeMatches your job preferences, job type is Full-time.</strong></p><p><strong>Easy Apply</strong></p><p><strong>SaveSave Software Developer– Orlando FL&nbsp; at Cogent Communications</strong></p><p><img src=\"https://www2.pcrecruiter.net/pcrbin/regmenu.aspx?boardid=%2F931GRS9rU4n%2FrKEVI%2BZbMJ1CqvNTgIA7t3e9%2By1HScDvtXfcwMq8NEDSU9HZwBu0pA%3D\"></p><h2><a href=\"https://www.linkedin.com/jobs/view/4250047005/?alternateChannel=search&amp;refId=L9W2R9s23MesKiozuuv3UQ%3D%3D&amp;trackingId=QJuG2ZUcVt2wN5I%2BG%2B6fMw%3D%3D\"><strong>Software Developer– Orlando FL</strong></a></h2><p>Cogent Communications · Orlando, FL (On-site)</p><p><strong>Easy Apply</strong></p><p><strong>SaveSave Software Developer– Orlando FL&nbsp; at Cogent Communications</strong></p><p><strong>Show more options</strong></p><p>&nbsp;</p><h2><strong>Job match is high, we can help you stand out</strong></h2><h3>Your profile matches the required qualifications well</h3><p>&nbsp;</p><ul><li><strong>Show match details</strong></li><li><strong>Tailor my resume</strong></li><li><strong>Help me standout</strong></li><li><strong>Create cover letter</strong></li></ul><p>BETA</p><p>Is this information helpful?</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>People you can reach out to</strong></h2><figure class=\"image\"><img src=\"https://media.licdn.com/dms/image/v2/C560BAQEFv0lqpE-gsQ/company-logo_100_100/company-logo_100_100/0/1631308876392?e=1765411200&amp;v=beta&amp;t=hDV6xTub04uPBnqRUPKFbpNrkOJajs_4jHQ9mBvdRoQ\" alt=\"Penn State University logo\"></figure><p>Penn State University logo</p><p>School alumni from Penn State University</p><p><strong>Show all</strong></p><h2><strong>Meet the hiring team</strong></h2><figure class=\"image\"><img src=\"https://media.licdn.com/dms/image/v2/D4E03AQEazYzH2Wq0bg/profile-displayphoto-shrink_100_100/profile-displayphoto-shrink_100_100/0/1719846381202?e=1765411200&amp;v=beta&amp;t=4_wtLnqdKcE0jfQp4fWEvvgrXd4vw4Wj7BO6Wq6_mik\" alt=\"Meryem M.\"></figure><p><a href=\"https://www.linkedin.com/in/meryem-m-235284161\"><strong>Meryem M.&nbsp;</strong></a></p><p>3rd</p><p>Global Corporate Recruiter</p><p>Job poster</p><p><strong>Message</strong></p><h2><strong>About the job</strong></h2><p><strong>Company</strong><br><br>Cogent Communications is a global, Tier 1 facilities-based ISP, consistently ranked as one of the top five networks in the world and is publicly traded on the NASDAQ Stock Market under the ticker symbol CCOI. Cogent specializes in providing businesses with high speed Internet access and Ethernet transport services. Cogent facilities-based, all-optical IP network backbone provides IP services globally. Since its inception, Cogent has unleashed the benefits of IP technology, building one of the largest and highest capacity IP networks in the world. This network enables Cogent to offer large bandwidth connections at highly competitive prices. Cogent also offers superior customer support by virtue of its end-to-end control of service delivery and network monitoring. A competitive base salary and a full benefits package including; Health, Dental, Vision, Paid Time Off (PTO), Short- and Long-Term Disability, Life Insurance, Holidays, Parental Leave, 401(k) plan with employer match, stock options, and an Employee Assistance Program. Most benefits take effect within 30 days of employment, and some require a waiting period.<br><br><strong>Job Summary</strong><br><br>The Software Developer will assist in the design, development and maintenance of a several in-house business applications to support Corporate Sales, Operations and Finance as well as other departments. Under the guidance of the technical lead, the developer will work with application stakeholders to gather requirements, produce proofs-of-concept, obtain feedback, and complete the development, testing and implementation of the applications. This developer will also assist in maintaining some existing PHP and Java applications<br><br><strong>Compensation</strong><br><br>[Starting / Initial] Base Salary Pay Range: $80,000-$110,000/yr.<br><br>Specific offers within the listed pay ranges are determined by a variety of factors such as experience, education, skills, certifications and business needs.<br><br><strong>Responsibilities</strong><br><br>&nbsp;</p><ul><li>Analyze technology/capability gaps, research, develop, and deploy software solutions</li><li>Work with project leads to define sprints and associated deliverables</li><li>Collaborate with other developers to design and optimize code</li><li>Conduct integration, test, bug fixes, and other software maintenance activities</li><li>Performing requirements analysis and proof of concept or prototyping as needed for engineering and design of corporate applications</li><li>Supporting applications in O&amp;M status by providing enhancements and bug fixes as needed</li><li>Coding, testing, and debugging new software or enhancements to existing software</li><li>Developing user interfaces and applications by setting expectations and feature priorities throughout the development life cycle, determining design methodologies and tool sets, completing programming using languages and software products, and designing and conducting tests</li><li>Integration of platforms leveraging APIs</li><li>Assist in the creation of technical documentation and user guides in support of developed software<br><br>&nbsp;</li></ul><p><strong>Qualifications</strong><br><br>&nbsp;</p><ul><li>3+ years of PHP web development experience</li><li>2+ years of experience with the Laravel Framework</li><li>2+ years of full-time experience with MySQL and/or MSSQL</li><li>Proficiency with HTML/CSS/JavaScript</li><li>Experience in all phases of SDLC, OO analysis and design, and revision control systems</li><li>Ability to converse with end-users, gather requirements, and provide feedback in plain non-technical English</li><li>Ability to structure a software project (UI / API / DB)</li><li>Ability to write clear, concise, and accurate technical documentation</li><li>At least 2 years of Computer Science college education or similar studies</li><li>Outstanding customer service and time management skills</li><li>Strong interpersonal, communication and organizational skills</li><li>Capable of writing and presenting detailed documentation<br><br>&nbsp;</li></ul><p><strong>Physical Requirements</strong><br><br>&nbsp;</p><ul><li>Frequently remains in a sitting/stationary position during the workday</li><li>Operates a computer and performs desk-based computer tasks continually, frequently viewing a computer screen<br><br>&nbsp;</li></ul><p><strong>COVID-19 Policy</strong><br><br>Cogent has adopted a mandatory vaccination and booster policy which requires all U.S. employees to be fully vaccinated with one booster against COVID-19. Prior to beginning employment, new employees must provide proof of vaccination or apply for and receive an accommodation to be exempt from the policy.<br><br>By submitting an application or resume for this position, I understand that is an in-office position and agree to abide Cogent’s mandatory vaccination policy.<br><br>To apply for the Software Developer position, please submit your resume and cover letter to <strong>careers@cogentco.com.</strong><br><br>Cogent Communications is an Equal Opportunity Employer.<br><br>&nbsp;</p><p>&nbsp;</p><h3><strong>Benefits found in job post</strong></h3><p>&nbsp;</p><ul><li>401(k)</li><li>Disability insurance</li></ul>
EOD,
            ],
            [
                'company_id'             => $companies['clampett-oil'] ?? null,
                'role'                   => 'Senior Software Engineer',
                'job_board_id'           => 9,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-17',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 130000,
                'compensation_max'       => 130000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://ielfreight.wd1.myworkdayjobs.com/external/job/Remote---Ohio/Senior-Software-Engineer_JR101899?source=Linkedin',
                'link_name'              => 'LinkedIn',
                'description'            => <<<EOD
<h2><strong>Senior Software Engineer</strong></h2><p><a href=\"https://ielfreight.wd1.myworkdayjobs.com/external/job/Remote---Ohio/Senior-Software-Engineer_JR101899/apply?source=Linkedin\"><strong>Apply</strong></a></p><p>&nbsp;</p><p>locations</p><p>Remote - Ohio</p><p>&nbsp;</p><p>time type</p><p>Full time</p><p>&nbsp;</p><p>posted on</p><p>Posted 11 Days Ago</p><p>&nbsp;</p><p>job requisition id</p><p>JR101899</p><p>The Senior Software Engineer works closely with product owners, QA engineers, software architects, data analysts, and UI/UX designers to build innovative and forward-thinking software applications that serve both our customers and internal company operations. Some applications include: IEL transportation management system, customer portal, carrier onboarding system, real-time rate pricing system, etc. The Sr Software Engineer is expected to follow team coding standards to write clean and concise code, work with QA to isolate and debug issues, and document all features/bug fixes. The Sr Software Engineer is full-stack, working across the whole software stack, and provides guidance and mentorship to other Software Engineers on the team.</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>Position Description (Essential Duties &amp; Responsibilities):</strong></h2><h2>Designing, coding, and modifying software applications according to business requirements.</h2><h2>Work primarily with Laravel PHP, Vue.js, PostgreSQL, HTML, CSS, and JavaScript.&nbsp;</h2><h2>Attend all relevant team meetings and take appropriate workloads based on their abilities.&nbsp;</h2><h2>Work on all aspects of software applications including the front-end, back-end, and database side.&nbsp;</h2><h2>Assist and mentor other Software Engineers on the team.&nbsp;</h2><h2>Actively participate in discussions about new application designs and troubleshooting software development related issues.&nbsp;</h2><h2>&nbsp;</h2><p>&nbsp;</p><p>&nbsp;</p><h2><strong>Knowledge/Skills/Experience:</strong></h2><h2>&nbsp;</h2><h2>Basic (Required)</h2><h2>Associates Degree in Computer Science or other related field and 3+ years of PHP coding experience, or 5+ years of equivalent professional work experience</h2><h2>Expert skill level in Laravel / PHP</h2><h2>Advanced skill level in HTML and CSS</h2><h2>Advanced skill level in JavaScript or Vue.js</h2><h2>Advanced skill level with relational database systems (i.e. PostgreSQL, MySQL, etc)</h2><h2>Advanced skill level with a source control software (i.e. Git, etc)</h2><h2>Intermediate skill level with Linux</h2><h2>Intermediate skill level configuring and administering a web server (NGINX, Apache, etc)</h2><h2>Good understanding and experience applying object-oriented programming</h2><h2>Good understanding and experience applying software design patterns</h2><h2>Good understanding and experience applying software architectural patterns</h2><h2>Good understanding and experience applying UI/UX design principles</h2><h2>Full confidence in ability to tackle all aspects of any software development project</h2><h2>Excellent problem-solving skills and Strong technical and non-technical communication skills</h2><h2>&nbsp;</h2><h2>Preferred:</h2><h2>Experience leading a team</h2><h2>Experience working in a small team</h2><h2>Experience working with Agile-Scrum methodology</h2><p>&nbsp;</p><p>&nbsp;</p><p>We are committed to providing reasonable accommodations for qualified individuals with disabilities in our job application procedures. If you need assistance or an accommodation due to a disability, you may contact us at HR@intxlog.com or call 1-888-374-5138 ext. 4.</p><p><br>&nbsp;</p><h3>US Based Employees - At IEL, we are committed to providing equal employment opportunities for all persons, regardless of age, ancestry, color, religious creed (including religious dress or grooming practice), family and medical care leave status, disability (mental and physical) including HIV and AIDS, marital status, medical condition (including cancer and genetic characteristics), genetic information, military status, protected veteran status, status as a victim of domestic violence or stalking, familiar status, national origin, race, sex, pregnancy, childbirth, breastfeeding or related medical condition, gender identity or expression, sexual orientation and or any other category protected by law.</h3>
EOD,
            ],
            [
                'company_id'             => $companies['oceanic-airlines'] ?? null,
                'role'                   => 'Software Engineer',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 0,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => '2025-11-26',
                'compensation_min'       => 130000,
                'compensation_max'       => 175000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/viewjob?jk=67be428d633ef5b9',
                'link_name'              => 'Indeed',
                'description'            => <<<EOD
<h2><strong>Software Engineer</strong></h2><p><a href=\"https://www.indeed.com/cmp/US-Service-Animals?campaignid=mobvjcmp&amp;from=mobviewjob&amp;tk=1jas8kgvqgnin800&amp;fromjk=67be428d633ef5b9\">US Service Animals</a></p><p>3.63.6 out of 5 stars</p><p>Remote</p><p>$130,000 - $175,000 a year - Full-time</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&amp;nbsp;</p><h2><strong>Profile insights</strong></h2><p>Here’s how the job qualifications align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Skills</strong></h3><p><strong>Web development</strong></p><p><strong>System design</strong></p><p><strong>Solution architecture design</strong></p><ul><li>+ show more</li></ul><p>Do you have experience in <strong>Web development</strong>?</p><p>&amp;nbsp;</p><h2><strong>Job details</strong></h2><p>Here’s how the job details align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Pay</strong></h3><p><strong>$130,000 - $175,000 a year</strong></p><h3><strong>Job type</strong></h3><p><strong>Full-time</strong></p><p>&amp;nbsp;</p><h2><strong>Benefits</strong></h2><p><strong>Pulled from the full job description</strong></p><ul><li>Health insurance</li><li>401(k) matching</li><li>Paid time off</li><li>Vision insurance</li><li>Dental insurance</li><li>Disability insurance</li></ul><p>&amp;nbsp;</p><h2><strong>Full job description</strong></h2><p><strong>About the Role:</strong></p><p><strong>US Service Animals</strong> and <strong>Dog Academy </strong>are currently recruiting for a Software Engineer who is a self-starter and takes initiative in tackling challenges with our web and mobile applications. We are a growing organization and building out many new products, so the Engineer will need to have an architectural mindset as we plan for scalability and the future. This candidate will collaborate with other developers on our team to research, plan, and build solutions to meet the businesses needs.</p><p><br>&nbsp;</p><p><strong>What You\'ll Bring</strong></p><ul><li>5+ years of experience with PHP, including an MVC framework like Laravel or Yii</li><li>Understanding of object-oriented programming principles &amp; design patterns</li><li>Experience developing and consuming API web services</li><li>Advanced proficiency with MySQL and database design</li><li>Experience using Git in a team setting</li><li>Working knowledge of Docker</li><li>A positive attitude and excellent communication skills (a must!)</li></ul><p><strong>What Will Set You Apart</strong></p><ul><li>A passion for writing clean, well-documented code</li><li>The ability to design software that\'s robust, secure, scalable, and built to last</li><li>You\'re a self-starter who\'s able to pick up a task and run with it (but you\'re also not afraid to ask questions)</li></ul><p><strong>What We Offer</strong></p><ul><li>Health insurance plans, including dental and vision insurance</li><li>401(k) + matching</li><li>Disability insurance</li><li>Generous paid time off policy</li><li>Investment in personal growth and training</li><li>A fun, relaxed culture filled with smart folks committed to success</li></ul><p>&nbsp;</p><p>As an equal opportunity employer, US Service Animals is committed to a diverse workforce. Employment decisions regarding recruitment and selection will be made without discrimination based on race, color, religion, national origin, gender, age, sexual orientation, physical or mental disability, genetic information or characteristic, gender identity and expression, veteran status, or other non-job-related characteristics or other prohibited grounds specified in applicable federal, state and local laws.</p><p>&nbsp;</p><p><br>&nbsp;</p>
EOD,
            ],
            [
                'company_id'             => $companies['yoyodyne-propulsion-sys'] ?? null,
                'role'                   => 'Full-Stack PHP Web Developer',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Dayton',
                'state_id'               => 36,
                'zip'                    => '45429',
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 1,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://omnispear.com/blog/careers/wanted-full-stack-php-web-developer',
                'link_name'              => null,
                'description'            => <<<EOD
<h2><strong>Job Description:</strong></h2><p>OmniSpear, Inc. is currently seeking versatile individuals eager to join our team of talented web professionals. Working in a business-to-business environment, you will be responsible for developing large and small web-based applications for our clients. Projects range from custom websites to complex SaaS, ERP, and CRM systems.</p><p>This is a full-time, remote, work-from-home position . You must be a U.S. citizen or permanent resident.</p><p><a href=\"mailto:careers@omnispear.com\">Apply Now at careers@omnispear.com</a></p><h2><strong>Requirements:</strong></h2><ul><li>3 to 5 years of experience with PHP / Laravel</li><li>Show the capability to learn new languages and existing code bases quickly</li><li>Experience with SQL (dialect not important)</li><li>Experience with JavaScript Frameworks and HTML/CSS</li><li>Clear communication and comprehension skills</li><li>Ability to manage multiple tasks simultaneously</li><li>Experience using source control such as Git</li></ul><p><br>&nbsp;</p><h2><strong>Responsibilities:</strong></h2><ul><li>Develop, support, and maintain web-based applications</li><li>Identify opportunities for application scalability, sustainability &amp; improvement</li><li>Evaluate customer or internally-driven functionality change requests for technical feasibility and level of effort</li><li>Track time spent on projects effectively</li><li>Document and write tests for code</li><li>Follow established development standards for the company and clients</li></ul><p><br>&nbsp;</p><h2><strong>Bonus Skills:</strong></h2><ul><li>Experience with Continuous Integration or Automated Deployments</li><li>Experience with Linux web server configuration</li></ul><p><br>&nbsp;</p><h2><strong>Perks:</strong></h2><ul><li>Health Insurance</li><li>IRA Plan with matching</li><li>Casual work environment</li><li>Friday Afternoon Creative Coding</li></ul><p>&nbsp;</p><p>Send resumes to&nbsp;<a href=\"mailto:careers@omnispear.com\">careers@omnispear.com</a>.</p><p><i>Tagged: Team, PHP, Developer</i></p>
EOD,
            ],
            [
                'company_id'             => $companies['cyberdyne-systems-corp'] ?? null,
                'role'                   => 'Senior Full-Stack Developer & Vue js',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 1,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 168,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://digitalminds.pk/job/senior-full-stack-developer-vue-js/',
                'link_name'              => null,
                'description'            => <<<EOD
<h3><strong>REMOTE WORKING – WITH ACTIV TRACK 7 HOURS PRODUCTIVE TIME</strong></h3><p>1 senior full-stack developer laravel and vue js. But with with extraordinary skills front end ui ux and with vue js. 2 years minimum experience with laravel and vue js and 5 years minimum experience php and js</p><p><strong>Job Category: </strong>Developer</p><p><strong>Job Type: </strong>Full Time</p><p><strong>Job Location: </strong>Remote</p><p><strong>Gender: </strong>Any</p><p><strong>Total Positions: </strong>1</p><p><strong>Experience: </strong>2 Years</p>
EOD,
            ],
            [
                'company_id'             => $companies['danconia-copper'] ?? null,
                'role'                   => 'Senior Laravel Developer',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-php-developer-[prettified]'] ?? null,
                'rating'                 => 2,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 55,
                'compensation_max'       => 85,
                'compensation_unit_id'   => 1,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 2,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 2,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Hillsboro',
                'state_id'               => 38,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/jobs?q=laravel&l=Remote&from=searchOnHP%2Cwhereautocomplete&start=10&vjk=029d248f509b3b8c',
                'link_name'              => null,
                'description'            => <<<EOD
<h2><strong>Senior Laravel Developer- job post</strong></h2><p>Business Draft</p><p>Hillsboro, OR 97006•Remote</p><p>$55 - $85 an hour - Part-time</p><p>Business Draft</p><p>Hillsboro, OR 97006•Remote</p><p>$55 - $85 an hour</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>Profile insights</strong></h2><p>Here’s how the job qualifications align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Skills</strong></h3><p><strong>System design</strong></p><p><strong>S3</strong></p><p><strong>Performance tuning</strong></p><ul><li>+ show more</li></ul><p>Do you have experience in <strong>System design</strong>?</p><p>&amp;nbsp;</p><h2><strong>Job details</strong></h2><p>Here’s how the job details align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Pay</strong></h3><p><strong>$55 - $85 an hour</strong></p><h3><strong>Job type</strong></h3><p><strong>Part-time</strong></p><p>&amp;nbsp;</p><h2><strong>Benefits</strong></h2><p><strong>Pulled from the full job description</strong></p><ul><li>Flexible schedule</li></ul><p>&amp;nbsp;</p><h2><strong>Full job description</strong></h2><p><strong>About Business Draft</strong></p><p>At Business Draft, we’re reshaping the future of talent acquisition. Our all-in-one ATS is already trusted by companies like Planet Fitness and Crumbl to simplify and scale their hiring processes. Now, we’re ready to go further – building advanced features, integrating new systems, and scaling our platform for enterprise clients.</p><p>We’re looking for a <strong>Senior Laravel Developer</strong> to join our mission as a part-time contractor, with full-time potential down the road. This isn’t a typical role – it’s an opportunity to take the lead on major initiatives, shape the product, and grow with us as we onboard some of the world’s most recognizable brands.</p><p><strong>What You’ll Be Doing</strong></p><ul><li><strong>Platform Ownership:</strong> Take full ownership of the development pipeline, ensuring our platform remains secure, scalable, and performant.</li><li><strong>Background Check Integration:</strong> Lead the next big milestone by integrating a new background check provider seamlessly into the platform.</li><li><strong>Enterprise-Ready Scaling:</strong> Implement robust solutions to handle an expanding user base, ensuring high availability and top-notch performance.</li><li><strong>SOC 2 Compliance:</strong> Collaborate with leadership to prepare the platform for SOC 2 compliance in 2025, driving secure practices and documentation.</li><li><strong>Integrations:</strong> Expand our platform by connecting to job boards, CRMs, and other critical third-party tools.</li><li><strong>DevOps Leadership:</strong> Optimize our AWS infrastructure to enable smooth scaling, load balancing, and cost-effective performance.</li><li><strong>Communicating: </strong>Perhaps the most important part of your job will be communicating with non-technical executives and stakeholders.</li></ul><p><strong>What You Bring</strong></p><ul><li><strong>Extensive Laravel Experience:</strong> Expertise in Laravel 11, with a proven ability to architect scalable, maintainable systems.</li><li><strong>Database Proficiency:</strong> Deep knowledge of MySQL, including query optimization and complex data relationships.</li><li><strong>AWS DevOps Expertise:</strong> Hands-on experience with AWS, including EC2, S3, and CI/CD pipelines.</li><li><strong>Exceptional Portfolio:</strong> A proven track record of delivering complex projects with measurable impact. We care deeply about your past work—be ready to showcase the projects you’re proudest of.</li><li><strong>Self-Starter Mentality:</strong> You work efficiently, solve problems independently, and deliver high-quality results on time. You will wear many hats effectively.</li></ul><p><strong>Why Join Us?</strong></p><ul><li><strong>Make a Difference:</strong> Shape the future of an ATS that’s already attracting enterprise clients.</li><li><strong>Work That Matters:</strong> Every project you deliver will impact real companies and job seekers.</li><li><strong>Big Projects, Big Impact:</strong> You’ll lead high-stakes initiatives, from background checks to scaling infrastructure.</li><li><strong>Growth Opportunity:</strong> We’re scaling fast, and there’s room to grow into a leadership role.</li><li><strong>Top-Tier Compensation:</strong> We recognize the value of great talent and pay accordingly.</li></ul><p><strong>Soft Skills:</strong></p><ul><li>Strong problem-solving skills with the ability to make key decisions independently.</li><li>Excellent written and verbal communication skills, particularly in explaining complex technical concepts to non-technical stakeholders.</li><li>Comfortable owning projects and driving them to completion.</li></ul><p><strong>Location:</strong></p><ul><li>This is a flexible, remote role for candidates based in the U.S.</li><li>This is a part-time, contract position with the potential for a full time contract or employee position.</li></ul><p><strong>Next Steps</strong></p><p>If you’re excited about taking on a role with autonomy, challenge, and the opportunity to make a significant impact, we’d love to hear from you. Bonus tip: the better your portfolio / numbers behind your claims, the more likely it is we\'ll move forward with your application.</p><p>Let’s build the future of hiring together.</p><p>&amp;nbsp;</p><p>If you require alternative methods of application or screening, you must approach the employer directly to request this as Indeed is not responsible for the employer\'s application process.</p>
EOD,
            ],
            [
                'company_id'             => $companies['kikis-delivery-service'] ?? null,
                'role'                   => 'Full Stack Software Engineer (Vue/Laravel)',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 100000,
                'compensation_max'       => 125000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'phone'                  => null,
                'email'                  => null,
                'health'                 => 0,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/viewjob?jk=6f724f6ecdd61360&tk=1jasel29sgil98c1&from=serp&vjs=3',
                'link_name'              => 'Indeed',
                'description'            => <<<EOD
<h2><strong>Full Stack Software Engineer (Vue/Laravel) – Remote</strong></h2><p><a href=\"https://www.indeed.com/cmp/Sportsrecruits?campaignid=mobvjcmp&amp;from=mobviewjob&amp;tk=1jasj54f0gllh80d&amp;fromjk=6f724f6ecdd61360\">SportsRecruits</a></p><p>3.03.0 out of 5 stars</p><p>Remote</p><p>$100,000 - $125,000 a year - Full-time</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&amp;nbsp;</p><h2><strong>Profile insights</strong></h2><p>Here’s how the job qualifications align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Skills</strong></h3><p><strong>System design</strong></p><p><strong>System architecture design</strong></p><p><strong>Scalable systems</strong></p><ul><li>+ show more</li></ul><p>Do you have experience in <strong>System design</strong>?</p><p>&amp;nbsp;</p><h2><strong>Job details</strong></h2><p>Here’s how the job details align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Pay</strong></h3><p><strong>$100,000 - $125,000 a year</strong></p><h3><strong>Job type</strong></h3><p><strong>Full-time</strong></p><p>&amp;nbsp;</p><h2><strong>Benefits</strong></h2><p><strong>Pulled from the full job description</strong></p><ul><li>Health insurance</li><li>401(k) matching</li><li>Vision insurance</li><li>Dental insurance</li></ul><p>&amp;nbsp;</p><h2><strong>Full job description</strong></h2><h3><strong>Full Stack Software Engineer (Remote)</strong></h3><p><strong>Location: Remote (US-based)</strong><br><strong>Reports to: CTO, SportsRecruits</strong></p><p><br>&nbsp;</p><h2>About SportsRecruits</h2><p>SportsRecruits is the leading sports recruiting network, connecting athletes, clubs, events, and college coaches in the recruiting process. The company’s network and tools are trusted by sports organizations such as the IWLCA, IMLCA, NFHCA, and Junior Volleyball Association. Every year, millions of connections are made on the network, resulting in commitments to the best academic and athletic institutions.</p><p>SportsRecruits is part of IMG Academy, the world\'s leading sports education brand. IMG Academy provides a holistic education model that empowers student-athletes to win their future, preparing them for college and for life. IMG Academy provides growth opportunities for all student-athletes through an innovative suite of on-campus and online experiences:</p><ul><li>Boarding school and camps, via a state-of-the-art campus in Bradenton, Fla.</li><li>Online coaching via IMG Academy+, with a focus on personal development through the lens of sport and performance</li><li>Online college recruiting, via NCSA and <strong>SportsRecruits</strong>, providing unmatched college recruiting education and services to student-athletes and their families, club coaches, and event operators, and is the premier service for college coaches.</li></ul><p><br>SportsRecruits is an equal opportunity employer and embraces diversity and equal opportunity on our team. Just like the student-athletes we support, we are trying to get better and stronger as a team everyday. We are committed to building a team that represents a variety of backgrounds, perspectives, and skills. We truly believe that the more inclusive our team is, the better we can serve all student-athletes, as well as their families and coaches, who are pursuing their dreams.</p><p><br>&nbsp;</p><h2>About the Team</h2><p>We are a product development team full of fun, intelligent, happy, and hardworking engineers, designers and product managers distributed across the United States. We are scaling our network and building innovative tools to empower student athletes, college coaches, and event operators. Our tools are built on top of technologies that span mobile and web applications, computer vision, and LLMs. Your input, code and problem solving skills will make a direct impact in how we scale and grow the company.</p><p>Our stack includes:</p><ul><li>Laravel + PHP8 backend APIs</li><li>Vue.js (v2 and v3) + Inertia.js + Tailwind frontend</li><li>React Native mobile applications</li><li>Python for internal tools and ML/LLM-based features</li><li>Infrastructure as code with Terraform, AWS Fargate, and a Jenkins-based CI/CD pipeline</li></ul><p>We emphasize performance, security, and maintainability—and we love solving problems that have real-world impact on student-athletes, coaches, and partners.</p><p><br>&nbsp;</p><h2>About the Position</h2><h3><strong>What You’ll Do</strong></h3><p>As a mid-level Full-Stack Engineer, you’ll play a critical role across the entire software lifecycle:</p><ul><li>Implement, and optimize new features across web and mobile platforms</li><li>Contribute to our Vue.js frontend (Inertia.js) and Laravel-based API</li><li>Collaborate with product managers, designers, and QA to deliver intuitive, high-impact experiences</li></ul><p>You will contribute to solving complex problems that will make our platform even better at connecting thousands of student athletes and college programs. Some interesting projects we’ve recently worked on are:</p><ul><li>In-browser video clipping and editing with computer vision driven isolation effects</li><li>React-native based hybrid iOS/Android app</li><li>Tools for partner events to import rosters of athletes with built-in column mapping, de-duping and validation rules to automatically merge duplicate user data</li></ul><h2>About You</h2><h3>Must-Haves:</h3><ul><li>2-3 years of professional software engineering experience</li><li>Expertise in at least one modern programming languages (e.g., PHP, Python, JavaScript, TypeScript)</li><li>Experience with at least one PHP MVC framework (Laravel or Symfony)</li><li>Strong frontend experience with Vue, React, or similar frameworks</li><li>Familiarity with relational databases (MySQL, PostgreSQL, etc.)</li><li>Comfortable writing and maintaining automated tests (unit, integration, E2E)</li><li>Passion for clean code, system design, and scalable architecture</li><li>Strong communication skills, positive attitude, and a collaborative mindset<br>&nbsp;</li></ul><h3>Nice-to-Haves:</h3><ul><li>Laravel, Vue, or TailwindCSS experience</li><li>Experience working with 3rd-party APIs and async job queues (SQS, Redis)</li><li>Knowledge of AI tooling, LLM integration, or computer vision</li><li>Exposure to agile methodologies (Scrum, Kanban, XP)<br>&nbsp;</li></ul><h2>Why Join Us?</h2><ul><li><strong>Meaningful Work</strong>: Help shape a platform that impacts thousands of student-athletes’ futures.</li><li><strong>Modern Stack</strong>: Work with Laravel, Vue, React Native, Python, and AWS, backed by great tooling and infrastructure.</li><li><strong>Growth-Oriented Culture</strong>: We prioritize learning, experimentation, and continuous improvement.</li><li><strong>Remote Flexibility</strong>: We’re a distributed team with asynchronous workflows and clear communication practices.</li></ul><p><strong>Benefits &amp; Compensation</strong></p><p>Competitive salary: $100,000 – $125,000 per year</p><p>Remote-first team culture</p><p>Health, dental, and vision coverage</p><p>401(k) with company match</p><p>Unlimited vacation policy</p><p>&nbsp;</p><p>yEdtjhFkby</p><p>&amp;nbsp;</p><p>If you require alternative methods of application or screening, you must approach the employer directly to request this as Indeed is not responsible for the employer\'s application process.</p><p>&nbsp;</p><p><br>&nbsp;</p>
EOD,
            ],
            [
                'company_id'             => $companies['gringotts'] ?? null,
                'role'                   => 'LAMP Software Engineer',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 3,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 5,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => null,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/jobs?q=laravel&l=Remote&from=searchOnHP&start=20&vjk=b99d722c4b6b5443',
                'link_name'              => null,
                'description'            => <<<EOD
<h2><strong>LAMP Software Engineer (Contractor)- job post</strong></h2><p><a href=\"https://www.indeed.com/cmp/Red-Hawk-Technologies?campaignid=mobvjcmp&amp;from=mobviewjob&amp;tk=1jask6n5j229m003&amp;fromjk=b99d722c4b6b5443\">Red Hawk Technologies LLC</a></p><p>Remote</p><p>Contract</p><p><a href=\"https://www.indeed.com/cmp/Red-Hawk-Technologies?campaignid=mobvjcmp&amp;from=mobviewjob&amp;tk=1jask6n5j229m003&amp;fromjk=b99d722c4b6b5443\">Red Hawk Technologies LLC</a></p><p>Remote</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>Profile insights</strong></h2><p>Here’s how the job qualifications align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Skills</strong></h3><p><strong>Web applications</strong></p><p><strong>Python</strong></p><p><strong>Linux</strong></p><ul><li>+ show more</li></ul><p>Do you have experience in <strong>Web applications</strong>?</p><h3><strong>Education</strong></h3><p><strong>Bachelor\'s degree</strong></p><p>&amp;nbsp;</p><h2><strong>Job details</strong></h2><p>Here’s how the job details align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Job type</strong></h3><p><strong>Contract</strong></p><p>&amp;nbsp;</p><h2><strong>Full job description</strong></h2><p>We are looking for a talented and experienced LAMP software engineer contractor to join our team. As a LAMP software engineer, you will be responsible for developing, maintaining, and deploying web applications using the LAMP stack (Linux, Apache, MySQL, PHP and Python). This particular role requires experience with Laravel. You will also be responsible for working with other members of the team to design and implement new features and functionality.</p><p>If you are a talented and experienced LAMP software engineer, we encourage you to apply for this exciting opportunity. To apply, please submit your resume to careers@redhawk-tech.com.</p><p><strong>Responsibilities:</strong></p><p>Develop, maintain, and deploy web applications using the LAMP stack</p><p>Work with other members of the team to design and implement new features and functionality</p><p>Troubleshoot and debug web applications</p><p>Work directly with clients and project managers to gather requirements and specifications, and execute</p><p>Stay up-to-date on the latest technologies and trends in web development</p><p>Ability to work independently and on multiple projects simultaneously</p><p><strong>Qualifications:</strong></p><p>Bachelor\'s degree in computer science or a related field</p><p>5+ years of experience in web development using the LAMP stack</p><p>Strong understanding of PHP, MySQL, and Apache. Demonstrated Laravel experience.</p><p>Experience with HTML, CSS, and JavaScript</p><p>Experience with Git and other version control systems</p><p>Excellent problem-solving and debugging skills</p><p>Excellent communication and teamwork skills, you will work directly with clients</p><p>&nbsp;</p><p>&amp;nbsp;</p><p>If you require alternative methods of application or screening, you must approach the employer directly to request this as Indeed is not responsible for the employer\'s application process.</p>
EOD,
            ],
            [
                'company_id'             => $companies['oscorp'] ?? null,
                'role'                   => 'PHP Laravel developer',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-php-developer-[prettified]'] ?? null,
                'rating'                 => 3,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => 'webrockmedia@gmail.com',
                'notes'                  => null,
                'link'                   => null,
                'link_name'              => null,
                'description'            => <<<EOD
<h2><a href=\"https://webrockmedia.com/job/php-laravel-developer/\">PHP Laravel developer</a></h2><p><strong>Job Type: </strong>Full time - Remote</p><p><strong>PHP / Laravel developer job profile</strong></p><p>PHP / Laravel developer is an IT professional specialized in developing web applications using Laravel Framework within PHP programming language.</p><p>In order to attract a PHP / Laravel developer that best matches your needs, it is very important to write a clear and precise PHP / Laravel developer job description.</p><p><strong>PHP / Laravel developer job description</strong></p><p>Are you a highly experienced, ambitious Fullstack developer looking for a challenging role where you can learn lots more?</p><p>We are looking for a motivated PHP / Laravel developer to come join our agile team of professionals.</p><p>If you are passionate about technology, constantly seeking to learn and improve your skillset, then you are the type of person we are looking for!</p><p>We are offering superb career growth opportunities, great compensation, and benefits.</p><p><strong>PHP / Laravel developer duties and responsibilities</strong></p><ul><li>Develop, record and maintain cutting edge web-based PHP applications on portal plus premium service platforms</li><li>Build innovative, state-of-the-art applications and collaborate with the User Experience (UX) team</li><li>Ensure HTML, CSS, and shared JavaScript is valid and consistent across applications</li><li>Prepare and maintain all applications utilizing standard development tools</li><li>Utilize backend data services and contribute to increase existing data services API</li><li>Lead the entire web application development life cycle right from concept stage to delivery and post launch support</li><li>Convey effectively with all task progress, evaluations, suggestions, schedules along with technical and process issues</li><li>Document the development process, architecture, and standard components</li><li>Coordinate with co-developers and keeps project manager well informed of the status of development effort and serves as liaison between development staff and project manager</li><li>Keep abreast of new trends and best practices in web development</li></ul><p><strong>PHP / Laravel developer requirements and qualifications</strong></p><ul><li>Previous working experience as a PHP / Laravel developer for 4 year(s)</li><li>BS/MS degree in Computer Science, Engineering, MIS or similar relevant field</li><li>In depth knowledge of object-oriented PHP and Laravel PHP Framework</li><li>Hands on experience with SQL schema design, SOLID principles, REST API design</li><li>Software testing (PHPUnit, PHPSpec, Behat)</li><li>MySQL profiling and query optimization</li><li>Creative and efficient problem solver</li></ul>
EOD,
            ],
            [
                'company_id'             => $companies['nakatomi-trading-corp'] ?? null,
                'role'                   => 'Senior PHP Programmers',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-php-developer-[prettified]'] ?? null,
                'rating'                 => 3,
                'active'                 => 1,
                'post_date'              => null,
                'apply_date'             => null,
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 5,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => 'Smyrna',
                'state_id'               => 11,
                'zip'                    => '30080',
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.indeed.com/jobs?q=laravel&l=Remote&from=searchOnHP&start=20&vjk=52c2ac4b6264189f',
                'link_name'              => 'Indeed',
                'description'            => <<<EOD
<h2><strong>Senior PHP Programmers- job post</strong></h2><p><a href=\"https://www.indeed.com/cmp/Venu-1?campaignid=mobvjcmp&amp;from=mobviewjob&amp;tk=1jasl6pk3229m000&amp;fromjk=52c2ac4b6264189f\">VenU eLearning Solutions</a></p><p>Smyrna, GA 30080•Remote</p><p>Full-time, Contract</p><p><a href=\"https://www.indeed.com/cmp/Venu-1?campaignid=mobvjcmp&amp;from=mobviewjob&amp;tk=1jasl6pk3229m000&amp;fromjk=52c2ac4b6264189f\">VenU eLearning Solutions</a></p><p>Smyrna, GA 30080•Remote</p><p>&nbsp;</p><p>&nbsp;</p><h2><strong>Profile insights</strong></h2><p>Here’s how the job qualifications align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Skills</strong></h3><p><strong>Web development</strong></p><p><strong>SVN</strong></p><p><strong>SSO</strong></p><ul><li>+ show more</li></ul><p>Do you have experience in <strong>Web development</strong>?</p><p>&amp;nbsp;</p><h2><strong>Job details</strong></h2><p>Here’s how the job details align with your <a href=\"https://profile.indeed.com/\">profile</a>.</p><h3><strong>Job type</strong></h3><p><strong>Contract</strong></p><p><strong>Full-time</strong></p><p>&amp;nbsp;</p><h2><strong>Benefits</strong></h2><p><strong>Pulled from the full job description</strong></p><ul><li>Work from home</li></ul><p>&amp;nbsp;</p><h2><strong>Full job description</strong></h2><p>VenU is a looking for talented and reliable developers with extensive experience in PHP/MySQL, CSS, HTML, SVN, and CMS systems. Additionally, experience developing ecommerce sites, Single Sign-On (SSO), database driven reports, and developing to secure application standards is required. Additionally, server configuration and system administration is desirable. You will join an existing small team of elite programmers and Project Managers. This is a long term (full-time contract)”work from home” position.<br>In addition to possessing strong technical skills, the critical personal attributes we are looking for are strong communication skills, positive attitude, dedication to teamwork, self-starter, detailed-oriented, reliable, innovator, etc.</p><p>This is a great opportunity if you are looking for a long term work, a strong supporting team, development freedom, and good pay.</p><p><strong>You must submit a cover letter along with your resume to be considered for this position. U.S. and Canadian Citizens Only. No Companies.</strong></p>
EOD,
            ],
            [
                'company_id'             => $companies['spacely-space-sprockets'] ?? null,
                'role'                   => 'Full Stack Engineer',
                'job_board_id'           => 3,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-24',
                'apply_date'             => '2025-11-24',
                'close_date'             => null,
                'compensation_min'       => 140000,
                'compensation_max'       => 180000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://www.putnamrecruiting.com/job/full-stack-engineer/',
                'link_name'              => null,
                'description'            => <<<EOD
<h2>Full Stack Engineer</h2><p><a href=\"https://www.putnamrecruiting.com/job/full-stack-engineer/#comments\">0</a></p><ul><li>Full Time</li><li><a href=\"https://maps.google.com/maps?q=Remote%2C+USA&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false\">Remote, USA</a></li></ul><p><strong>Snapshot:</strong></p><p>We are a well-backed Healthtech company and the nation’s largest healthcare consulting firm. We help hospitals, health clinics, and surgery centers to run their business more effectively through a self-managed, consultative partnership, which makes the practice much easier and more efficient.</p><p><strong>Who You Are:</strong></p><p>You like to work on all parts of your projects from beginning to end and get as much satisfaction from continually improving something as you do from starting something new.<br>You’re able to take a set of project requirements — or even a well-described idea— and turn it into a working product without much (if any) assistance.<br>You mostly develop for the web but are interested in branching out to other areas (native application development? AI/ML? UI/UX? etc.) and value the opportunity to do so.<br>You’re not intimidated by challenges and welcome the opportunity to participate in all phases of software development as needed.<br>You’re comfortable working cross-functionally with different teams and departments (both technical and non-technical).</p><p><strong>Responsibilities:</strong></p><p>The key responsibility of this position is to develop end-to-end solutions for our clients and for internal use. You will be working with a small group of developers and project managers, and be joining a team that is tasked with building the systems that will take us into our third decade.<br>Write front-end and back-end code with a solid grasp of SDLC best practices (we use PHP)<br>Use a framework to create performant, reliable HTTP-based APIs (we use Laravel).<br>Wire API’s to a modern front-end framework (we use Vue.js)<br>Write unit, integration, and end-to-end tests, and understand the importance of test-driven development.<br>Deploy, monitor, and troubleshoot your systems in staging and production environments.</p><p><strong>Qualifications:</strong></p><p>Minimum of 3+ years of hands-on, production-level Software Development experience (preferably with some experience in our stack: PHP/Laravel, Vue.js)<br>Familiarity with Git and understanding of the basics of CI/CD<br>Good verbal and written communications skills<br>A willingness to take initiative and ownership in a small-company environment<br>The ability to work remotely in an efficient manner<br>Healthcare or HealthTech industry experience is a plus, but not required</p><p>Salary range: $140,000-$180,000</p>
EOD,
            ],
            [
                'company_id'             => $companies['international-genetic-technologies'] ?? null,
                'role'                   => 'Senior Software Engineer',
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 4,
                'active'                 => 1,
                'post_date'              => '2025-11-25',
                'apply_date'             => '2025-11-25',
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'country_id'             => 237,
                'zip'                    => null,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => 'https://craneware.my.salesforce-sites.com/cranewarecareers/fRecruit__ApplyJob?vacancyNo=VN1612',
                'link_name'              => null,
                'description'            => <<<EOD
<h2>Job Details: Senior Software Engineer</h2><p>Full details of the job.</p><figure class=\"table\"><table><tbody><tr><td>&nbsp;</td><td><ul><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li><li>&nbsp;</li></ul></td></tr></tbody></table></figure><figure class=\"table\"><table><tbody><tr><th><strong>Vacancy Name</strong></th><td>Senior Software Engineer</td></tr><tr><th><strong>Company</strong></th><td>Sentry Data Systems</td></tr><tr><th><strong>Speciality</strong></th><td>Technology</td></tr><tr><th><strong>Category</strong></th><td>Permanent</td></tr><tr><th><strong>Location Country</strong></th><td>&nbsp;</td></tr><tr><th><strong>Office Location</strong></th><td>Home based - US</td></tr><tr><th><strong>Additional Locations</strong></th><td>&nbsp;</td></tr><tr><th><strong>Introduction to Craneware</strong></th><td><figure class=\"table\"><table><tbody><tr><td>Let’s transform the business of healthcare! At The Craneware Group, we are dedicated to empowering our customers with industry-defining insights that pave the way for a brighter future.&nbsp;<br><br>If you are an energetic, forward-thinking individual with a passion for innovation, we invite you to join our thriving team of more than 750 dedicated professionals. Together, we\'ll fuel the expansion of our SaaS platform and develop cutting-edge applications that redefine the healthcare landscape.<br><br>&nbsp;</td></tr></tbody></table></figure></td></tr><tr><th><strong>The Team</strong></th><td><figure class=\"table\"><table><tbody><tr><td>Craneware is looking for passionate Senior Software Engineers to design, develop and deliver high quality software solutions for TCG products which drive improvements in the US-based healthcare market.&nbsp;We are growing a team of strong thinkers and innovators that are willing to work closely with product and customer-facing teams to design and develop new applications in the Cloud.<br><br>The Senior Software Developer is a self-motivated, responsible technologist who thrives in an agile and demanding environment.&nbsp; This Developer is driven to understand and meet customer expectations by building high performing, enterprise grade solutions. This role is for someone who works with large amounts of data, solve problems, and thrives in finding unique solutions to those problems.</td></tr></tbody></table></figure></td></tr><tr><th><strong>You Will Be</strong></th><td><figure class=\"table\"><table><tbody><tr><td><ul><li>Working in a highly energized, fast paced, agile environment.</li><li>Developing and maintaining scalable web applications while ensuring performance and reliable database interactions for large, data-intensive workloads.</li><li>Creating and consuming web-based APIs with a strong focus on RESTful design and integration.</li><li>Collaborating with team members to solve real-world problems using prototypical examples, scenarios, and simulations.</li><li>Contributing as a proactive team member, supporting departmental goals and objectives.</li><li>Setting high personal expectations, demonstrating a strong sense of ownership, and encouraging the same in others.</li><li>Communicating effectively, delivering the right information at the right level of detail and at the right time, according to technical, business, and customer needs.</li><li>Establishing and maintaining professional working relationships with all levels of staff and external partners.</li><li>Providing constructive feedback and mentoring other developers, fostering a collaborative and growth-oriented environment.</li></ul></td></tr></tbody></table></figure></td></tr><tr><th><strong>You Will Bring</strong></th><td><figure class=\"table\"><table><tbody><tr><td><ul><li>Bachelor\'s degree in Computer Science or equivalent combination of related experience.</li><li>Strong understanding of object-oriented principles and design as well as MVC and SOA architectures.</li><li>Advanced proficiency in PHP, with extensive hands-on experience using frameworks such as Symfony or Laravel.</li><li>Solid experience designing and maintaining test suites with PHPUnit (or a similar framework) and integrating them into a CI/CD workflow.</li><li>Proficiency in database concepts, SQL and relational databases (PostgreSQL, Oracle, SQLite, MySQL, SQL Server).</li><li>Solid knowledge of front-end web technologies (HTML, CSS, JavaScript). Experience with a framework such as Angular, React or Vue is a plus.</li><li>Exposure to cloud platforms (AWS, Azure, or GCP), CI/CD pipelines, and containerization (Docker, Kubernetes) is a plus.</li><li>Experience with clustered or distributed computing is also a plus.</li><li>Detail oriented and self-motivated, with the ability to work with minimum/no supervision.</li><li>Ability to understand and follow verbal and written communications.</li><li>Willingness to be a collaborative team member and cooperate in the accomplishment of departmental goals and objectives.</li><li>A desire to help other engineers grow and raise code quality, supported by practical experience in mentoring, reviewing pull requests and sharing knowledge across an organization.</li><li>Openness to and proficiency in learning new technologies and approaches</li></ul></td></tr></tbody></table></figure></td></tr></tbody></table></figure>
EOD,
            ],
            /*
            [
                'id'                     => $this->applicationId[1],
                'company_id'             => $companies['wonka-industries'] ?? null,
                'role'                   => '',
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecruiter
                'resume_id'              => $this->resumes['2025-07-22-senior-full-stack-developer-[prettified]'] ?? null,
                'rating'                 => 1,
                'active'                 => 1,
                'post_date'              => null,
                'apply_date'             => null,
                'close_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'street'                 => null,
                'street2'                => null,
                'city'                   => null,
                'state_id'               => null,
                'zip'                    => null,
                'country_id'             => 237,
                'bonus'                  => null,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'phone'                  => null,
                'email'                  => null,
                'notes'                  => null,
                'link'                   => null,
                'link_name'              => null,
                'description'            => null,
            ],
            */
        ];

        $applicationModel = new Application();

        if (!empty($data)) {
            foreach ($data as $i=>$dataArray) {
                $dataArray = [$dataArray];
                $applicationModel->insert($this->additionalColumns($dataArray, true, $this->adminId, ['demo' => $this->demo]));
            }
            //$this->insertSystemAdminResource($this->adminId, 'applications');
        }

        $this->applications = [];
        $query = $applicationModel->withoutGlobalScope(AdminPublicScope::class)
            ->selectRaw('applications.id as application_id, companies.slug as company_slug')
            ->where('applications.owner_id', $this->adminId)
            ->join(config('app.career_db').'.companies', 'companies.id', '=', 'company_id')
            ->orderBy('companies.slug');
        foreach ($query->get() as $row) {
            $this->applications[$row->company_slug] = $row->application_id;
        }
    }

    /**
     * @return void
     */
    protected function insertCareerApplicationSkill(): void
    {
        echo self::USERNAME . ": Inserting into Career\\ApplicationSkill ...\n";

        $data = [
            /*
            [
                'application_id'         => $this->applicationId[1],
                'name'                   => '',
                'level'                  => 5,
                'dictionary_category_id' => null,
                'dictionary_id_term_id'  => null,
                'start_year'             => 2020,
                'end_year'               => 2055,
                'years'                  => 5,
            ]
            */
        ];

        if (!empty($data)) {
            new ApplicationSkill()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'application_skills');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerCompanies(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Company ...\n";

        $companyModel = new Company();

        $this->companyId = [];
        $maxId = $companyModel->withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=84; $i++) {
            $this->companyId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->companyId[1],   'name' => 'CHOAM',                                'slug' => 'choam',                                'industry_id' => 11, 'city' => null,                'state_id' => 10,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[2],   'name' => 'ACME Corp.',                           'slug' => 'acme-corp',                            'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[3],   'name' => 'Randstad',                             'slug' => 'randstad',                             'industry_id' => 11, 'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[4],   'name' => 'Sirius Cybernetics Corporation',       'slug' => 'sirius-cybernetics-corporation',       'industry_id' => 11, 'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[5],   'name' => 'MomCorp',                              'slug' => 'momcorp',                              'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[6],   'name' => 'Rich Industries',                      'slug' => 'rich-industries',                      'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[7],   'name' => 'Soylent Corporation',                  'slug' => 'soylent-corporation',                  'industry_id' => 4,  'city' => null,                'state_id' => 34,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[8],   'name' => 'Very Big Corporation of America',      'slug' => 'very-big-corporation-of-america',      'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[9],   'name' => 'Frobozz Magic Co.',                    'slug' => 'frobozz-magic-co',                     'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[10],  'name' => 'Warbucks Industries',                  'slug' => 'warbucks-industries',                  'industry_id' => 11, 'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[11],  'name' => 'Tyrell Corp.',                         'slug' => 'tyrell-corp',                          'industry_id' => 11, 'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[12],  'name' => 'Initech',                              'slug' => 'initech',                              'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[13],  'name' => 'Wayne Enterprises',                    'slug' => 'wayne-enterprises',                    'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[14],  'name' => 'Virtucon',                             'slug' => 'virtucon',                             'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[15],  'name' => 'Globex',                               'slug' => 'globex',                               'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[16],  'name' => 'Umbrella Corp.',                       'slug' => 'umbrella-corp',                        'industry_id' => 11, 'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[17],  'name' => 'Stark Industries',                     'slug' => 'stark-industries',                     'industry_id' => 11, 'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[18],  'name' => 'Clampett Oil',                         'slug' => 'clampett-oil',                         'industry_id' => 11, 'city' => null,                'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[19],  'name' => 'Oceanic Airlines',                     'slug' => 'oceanic-airlines',                     'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[20],  'name' => 'Yoyodyne Propulsion Sys.',             'slug' => 'yoyodyne-propulsion-sys',              'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[21],  'name' => 'Cyberdyne Systems Corp.',              'slug' => 'cyberdyne-systems-corp',               'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[22],  'name' => 'd\'Anconia Copper',                    'slug' => 'danconia-copper',                      'industry_id' => 11, 'city' => null,                'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[23],  'name' => 'Kiki\'s Delivery Service',             'slug' => 'kikis-delivery-service',               'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[24],  'name' => 'Gringotts',                            'slug' => 'gringotts',                            'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[25],  'name' => 'Oscorp',                               'slug' => 'oscorp',                               'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[26],  'name' => 'Nakatomi Trading Corp.',               'slug' => 'nakatomi-trading-corp',                'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[27],  'name' => 'Spacely Space Sprockets',              'slug' => 'spacely-space-sprockets',              'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[28],  'name' => 'International Genetic Technologies',   'slug' => 'international-genetic-technologies',   'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[29],  'name' => 'Wonka Industries',                     'slug' => 'wonka-industries',                     'industry_id' => 10, 'city' => null,                'state_id' => 6,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[30],  'name' => 'Weyland-Yutani',                       'slug' => 'weylandyutani',                        'industry_id' => 11, 'city' => null,                'state_id' => 22,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[31],  'name' => 'Pierce & Pierce',                      'slug' => 'pierce-and-pierce',                    'industry_id' => 11, 'city' => null,                'state_id' => 11,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[32],  'name' => 'Compu-Global-Hyper-Mega-Net',          'slug' => 'compu-global-hyper-mega-net',          'industry_id' => 11, 'city' => null,                'state_id' => 22,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[33],  'name' => 'Silver Shamrock Novelties',            'slug' => 'silver-shamrock-novelties',            'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[34],  'name' => 'Ollivander\'s Wand Shop',              'slug' => 'ollivanders-wand-shop',                'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[35],  'name' => 'Gekko and Co.',                        'slug' => 'gekko-and-co',                         'industry_id' => 11, 'city' => null,                'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[36],  'name' => 'Cheers',                               'slug' => 'cheers',                               'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[37],  'name' => 'Callister Inc',                        'slug' => 'callister-inc',                        'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[38],  'name' => 'The Krusty Krab',                      'slug' => 'the-krusty-krab',                      'industry_id' => 11, 'city' => null,                'state_id' => 31,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[39],  'name' => 'Good Burger',                          'slug' => 'good-burger',                          'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[40],  'name' => 'Quick Stop',                           'slug' => 'quick-stop',                           'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[41],  'name' => 'Burns Industries',                     'slug' => 'burns-industries',                     'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[42],  'name' => 'Buy n\' Large',                        'slug' => 'byu-n-large',                          'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[43],  'name' => 'Curl Up and Dye',                      'slug' => 'curl-up-and-dye',                      'industry_id' => 11, 'city' => null,                'state_id' => 11,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[44],  'name' => 'Bushwood Country Club',                'slug' => 'bushwood-country-club',                'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[45],  'name' => 'Dunder Mifflin Paper Company, Inc',    'slug' => 'dunder-mifflin-paper-company-inc',     'industry_id' => 11, 'city' => null,                'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[46],  'name' => 'Prestige Worldwide',                   'slug' => 'prestige-worldwide',                   'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[47],  'name' => 'Brawndo',                              'slug' => 'brwando',                              'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[48],  'name' => 'Aperture Science, Inc.',               'slug' => 'aperture-science-inc',                 'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[49],  'name' => 'Lacuna, Inc.',                         'slug' => 'lacuna-inc',                           'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[50],  'name' => 'Monsters, Inc.',                       'slug' => 'monsters-inc',                         'industry_id' => 11, 'city' => 'Chantilly',           'state_id' => 47,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[51],  'name' => 'Los Pollos Hermanos',                  'slug' => 'los-pollos-hermanos',                  'industry_id' => 11, 'city' => 'Santa Monica',        'state_id' => 5,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[52],  'name' => 'SPECTRE',                              'slug' => 'spectre',                              'industry_id' => 11, 'city' => 'Knoxville',           'state_id' => 43,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[53],  'name' => 'Pied Piper',                           'slug' => 'pied-piper',                           'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[54],  'name' => 'The Daily Planet',                     'slug' => 'the-daily-planet',                     'industry_id' => 11, 'city' => 'Bridgewater',         'state_id' => 31,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[55],  'name' => 'Planet Express, Inc.',                 'slug' => 'planet-express-inc',                   'industry_id' => 11, 'city' => 'Columbus',            'state_id' => 36,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[56],  'name' => 'InGen',                                'slug' => 'ingen',                                'industry_id' => 11, 'city' => 'Washington',          'state_id' => 9,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[57],  'name' => 'Outdoor Man',                          'slug' => 'outdoor-man',                          'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[58],  'name' => 'Empire Records',                       'slug' => 'empire-records',                       'industry_id' => 11, 'city' => 'Thousand Oaks',       'state_id' => 5,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[59],  'name' => 'Pendant Publishing',                   'slug' => 'pendant-publishing',                   'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[60],  'name' => 'Vandelay Industries',                  'slug' => 'vandelay-industries',                  'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[61],  'name' => 'WKRP',                                 'slug' => 'wkrp',                                 'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[62],  'name' => 'Sterling Cooper Advertising Agency',   'slug' => 'sterling-copper-advertising-agency',   'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[63],  'name' => 'Championship Vinyl',                   'slug' => 'championship-vinyl',                   'industry_id' => 11, 'city' => 'Altamonte Springs',   'state_id' => 10,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[64],  'name' => 'Bluth Company',                        'slug' => 'bluth-company',                        'industry_id' => 11, 'city' => 'St. Louis Park',      'state_id' => 24,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[65],  'name' => 'Duff Beer',                            'slug' => 'duff-beer',                            'industry_id' => 11, 'city' => 'Ogden',               'state_id' => 45,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[66],  'name' => 'Central Perk',                         'slug' => 'central-perk',                         'industry_id' => 11, 'city' => 'Washington',          'state_id' => 9,    'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[67],  'name' => 'Ghostbusters',                         'slug' => 'ghostbusters',                         'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[68],  'name' => 'SCP Foundation',                       'slug' => 'scp-foundation',                       'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[69],  'name' => 'Shinra Electric Power Company',        'slug' => 'shinra-electric-power-company',        'industry_id' => 11, 'city' => 'Bedford',             'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[70],  'name' => 'Tian Industries',                      'slug' => 'tina-industries',                      'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[71],  'name' => 'RDA Corporation',                      'slug' => 'rda-corporation',                      'industry_id' => 11, 'city' => 'Mason',               'state_id' => 36,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[72],  'name' => 'InterGalactic Banking Clan',           'slug' => 'intergalactic-banking-clan',           'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[73],  'name' => 'The Bank of Evil',                     'slug' => 'the-bank-of-evil',                     'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[74],  'name' => 'Parallax Corporation',                 'slug' => 'parallax-corporation',                 'industry_id' => 11, 'city' => 'Salt Lake City',      'state_id' => 45,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[75],  'name' => 'Mitch and Murray',                     'slug' => 'mitch-and-murray',                     'industry_id' => 11, 'city' => 'Indianapolis',        'state_id' => 15,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[76],  'name' => 'Megadodo Publications',                'slug' => 'megadodo-publications',                'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[77],  'name' => 'Multi National United',                'slug' => 'multi-national-united',                'industry_id' => 11, 'city' => 'Milwaukee',           'state_id' => 50,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[78],  'name' => 'Crimson Permanent Assurance',          'slug' => 'crimson-permanent-assurance',          'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[79],  'name' => 'Spectacular Optical',                  'slug' => 'spectacular-optical',                  'industry_id' => 11, 'city' => 'Austin',              'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[80],  'name' => 'Resources Development Administration', 'slug' => 'resources-development-administration', 'industry_id' => 11, 'city' => 'Plano',               'state_id' => 44,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[81],  'name' => 'Adventureland',                        'slug' => 'adventureland',                        'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[82],  'name' => 'Duke & Duke',                          'slug' => 'duke-and-duke',                        'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[83],  'name' => 'Lunar Industries',                     'slug' => 'lunar-industries',                     'industry_id' => 11, 'city' => 'Baltimore',           'state_id' => 21,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            [ 'id' => $this->companyId[84],  'name' => 'McDowell\'s',                          'slug' => 'mcdowells',                            'industry_id' => 11, 'city' => 'Idaho Falls',         'state_id' => 13,   'country_id' => 237,  'logo' => null, 'logo_small'  => null ],
            //[ 'id' => 1,                     'name' => '',                                     'slug' => '',                                     'industry_id' => 11, 'city' => null,                  'state_id' => null, 'country_id' => null, 'logo' => null, 'logo_small'  => null ],
        ];

        if (!empty($data)) {
            $companyModel->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'companies');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerCompanyContacts(): void
    {
        echo self::USERNAME . ": Inserting into Career\\CompanyContact ...\n";

        $data = [
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[1],  'contact_id' => $this->contactId[1],  'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[2],  'contact_id' => $this->contactId[2],  'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[4],  'contact_id' => $this->contactId[3],  'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[6],  'contact_id' => $this->contactId[4],  'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[7],  'contact_id' => $this->contactId[5],  'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[8],  'contact_id' => $this->contactId[6],  'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[10], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[11], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[12], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[9],  'contact_id' => $this->contactId[13], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[2],  'contact_id' => $this->contactId[14], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[12], 'contact_id' => $this->contactId[16], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[13], 'contact_id' => $this->contactId[17], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[14], 'contact_id' => $this->contactId[8],  'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[15], 'contact_id' => $this->contactId[19], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[21], 'contact_id' => $this->contactId[20], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[22], 'contact_id' => $this->contactId[21], 'active' => 1 ],
            [ 'owner_id' => $this->adminId, 'company_id' => $this->companyId[23], 'contact_id' => $this->contactId[23], 'active' => 1 ],
        ];

        if (!empty($data)) {
            new CompanyContact()->insert($this->additionalColumns($data));
        }
    }

    /**
     * @return void
     */
    protected function insertCareerContacts(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Contact ...\n";

        $contactModel = new Contact();

        $this->contactId = [];
        $maxId = $contactModel->withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=23; $i++) {
            $this->contactId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->contactId[1],   'name' => 'Ted Lasso',               'slug' => 'ted-lasso',               'phone' => null,	            'phone_label' => null,   'email' => 'Chad.Vasquez@CyberCoders.com',         'email_label' => 'work' ],
            [ 'id' => $this->contactId[2],   'name' => 'Moira Rose',              'slug' => 'moira-rose',              'phone' => null,	            'phone_label' => null,   'email' => 'lyman.ambrose@mondo.com',              'email_label' => 'work' ],
            [ 'id' => $this->contactId[3],   'name' => 'Joey Tribbiani',          'slug' => 'joey-tribbiani',          'phone' => null,             'phone_label' => null,   'email' => 'milesb@infinity-cs.com',               'email_label' => 'work' ],
            [ 'id' => $this->contactId[4],   'name' => 'Stewie Griffin',          'slug' => 'stewie-griffin',          'phone' => null,	            'phone_label' => null,   'email' => 'jolly.nibu@artech.com',                'email_label' => 'work' ],
            [ 'id' => $this->contactId[5],   'name' => 'Edmund Blackadder',       'slug' => 'edmund-blackadder',       'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[6],   'name' => 'David Brent',             'slug' => 'david-brent',             'phone' => null,	            'phone_label' => null,   'email' => 'jluehmann@horizontal.com',             'email_label' => 'work' ],
            [ 'id' => $this->contactId[7],   'name' => 'Troy Barnes',             'slug' => 'troy-barnes',             'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[8],   'name' => 'Selina Meyer',            'slug' => 'selina-meyer',            'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[9],   'name' => 'Blanche Devereaux',       'slug' => 'blanche-devereaux',       'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[10],  'name' => 'Patsy Stone',             'slug' => 'patsy-stone',             'phone' => null,             'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[11],  'name' => 'Tracy Jordan',            'slug' => 'tracy-jordan',            'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[12],  'name' => 'Father Dougal Mcguire',   'slug' => 'father-dougal-mcguire',   'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[13],  'name' => 'Malcolm Tucker',          'slug' => 'malcolm-tucker',          'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[14],  'name' => 'Del Boy Trotter',         'slug' => 'del-boy-trotter',         'phone' => null,	            'phone_label' => null,   'email' => 'dylan.rogelstad@mail.cybercoders.com', 'email_label' => 'work' ],
            [ 'id' => $this->contactId[15],  'name' => 'Arnold J Rimmer',         'slug' => 'arnold-j-rimmer',         'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[16],  'name' => 'Bob Belcher',             'slug' => 'bob-belcher',             'phone' => null,             'phone_label' => null,   'email' => 'tlesnick@trovasearch.com',             'email_label' => 'work' ],
            [ 'id' => $this->contactId[17],  'name' => 'Tahani Al-Jamil',         'slug' => 'tahani-al-jamil',         'phone' => null,             'phone_label' => null,   'email' => 'Ciara.Monahan@insightglobal.com',      'email_label' => 'work' ],
            [ 'id' => $this->contactId[18],  'name' => 'Norman Stanley Fletcher', 'slug' => 'norman-stanley-fletcher', 'phone' => null,	            'phone_label' => null,   'email' => 'rob@yscouts.com',                      'email_label' => 'work' ],
            [ 'id' => $this->contactId[19],  'name' => 'Richard Richard',         'slug' => 'richard-richard',         'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[20],  'name' => 'Jim Royle',               'slug' => 'jim-royle',               'phone' => '(774) 555-1614', 'phone_label' => 'work', 'email' => 'kelsey.higgins@klaviyo.com',           'email_label' => 'work' ],
            [ 'id' => $this->contactId[21],  'name' => 'Jill Tyrell',             'slug' => 'jill-tyrell',             'phone' => null,	            'phone_label' => null,   'email' => 'coleman@lendflow.io',                  'email_label' => 'work' ],
            [ 'id' => $this->contactId[22],  'name' => 'Archie Bunker',           'slug' => 'archie-bunker',           'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            [ 'id' => $this->contactId[23],  'name' => 'Willy Gilligan',          'slug' => 'willy-gilligan',          'phone' => null,	            'phone_label' => null,   'email' => null,                                   'email_label' => null   ],
            //[ 'id' => 1,   'name' => '',     'slug' => '',                 'phone' => null,	           'phone_label' => null,   'email' => null,                                   'email_label' => null ],
        ];

        if (!empty($data)) {
            $contactModel->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'contacts');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerCommunications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Communication ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'body'           => null,
            ]
            */
        ];

        if (!empty($data)) {
            new Communication()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'communications');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerCoverLetters(): void
    {
        echo self::USERNAME . ": Inserting into Career\\CoverLetter ...\n";

        $data = [
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['choam'],
                'name'           => 'CHOAM',
                'slug'           => '2025-11-24-choam',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['acme-corp'],
                'name'           => 'ACME Corp.',
                'slug'           => '2025-11-24-acme-corp',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['randstad'],
                'name'           => 'Randstad',
                'slug'           => '2025-11-24-randstad',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['sirius-cybernetics-corporation'],
                'name'           => 'Sirius Cybernetics Corporation',
                'slug'           => '2025-11-23-sirius-cybernetics-corporation',
                'date'           => '2025-11-23',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['momcorp'],
                'name'           => 'MomCorp',
                'slug'           => '2025-11-24-momcorp',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['rich-industries'],
                'name'           => 'Rich Industries',
                'slug'           => '2025-11-23-rich-industries',
                'date'           => '2025-11-23',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['soylent-corporation'],
                'name'           => 'Soylent Corporation',
                'slug'           => '2025-11-24-soylent-corporation',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['very-big-corporation-of-america'],
                'name'           => 'Very Big Corporation of America',
                'slug'           => '2025-11-24-very-big-corporation-of-america',
                'date'           => '2025-11-24--',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['frobozz-magic-co'],
                'name'           => 'Frobozz Magic Co.',
                'slug'           => '2025-11-24-frobozz-magic-co',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['warbucks-industries'],
                'name'           => 'Warbucks Industries',
                'slug'           => '2025-11-24-warbucks-industries',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['tyrell-corp'],
                'name'           => 'Tyrell Corp.',
                'slug'           => '2025-10-24-tyrell-corp',
                'date'           => '2025-10-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['initech'],
                'name'           => 'Initech',
                'slug'           => '2025-11-24-initech',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['wayne-enterprises'],
                'name'           => 'Wayne Enterprises',
                'slug'           => '2025-10-24-wayne-enterprises',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['virtucon'],
                'name'           => 'Virtucon',
                'slug'           => '2025-11-24-virtucon',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['globex'],
                'name'           => 'Globex',
                'slug'           => '2025-11-24-globex',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['umbrella-corp'],
                'name'           => 'Umbrella Corp.',
                'slug'           => '2025-11-24-umbrella-corp',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['stark-industries'],
                'name'           => 'Stark Industries',
                'slug'           => '2025-11-24-stark-industries',
                'date'           => '2025-11-24-',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['clampett-oil'],
                'name'           => 'Clampett Oil',
                'slug'           => '2025-11-24-clampett-oil',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['oceanic-airlines'],
                'name'           => 'Oceanic Airlines',
                'slug'           => '2025-11-24-oceanic-airlines',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['yoyodyne-propulsion-sys'],
                'name'           => 'Yoyodyne Propulsion Sys.',
                'slug'           => '2025-11-24-yoyodyne-propulsion-sys',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['cyberdyne-systems-corp'],
                'name'           => 'Cyberdyne Systems Corp.',
                'slug'           => '2025-11-24-cyberdyne-systems-corp',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['danconia-copper'],
                'name'           => 'd\'Anconia Copper',
                'slug'           => '2025-11-24-danconia-copper',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['kikis-delivery-service'],
                'name'           => 'Kiki\'s Delivery Service',
                'slug'           => '2025-11-24-kikis-delivery-service',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['gringotts'],
                'name'           => 'Gringotts',
                'slug'           => '2025-11-24-gringotts',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['oscorp'],
                'name'           => 'Oscorp',
                'slug'           => '2025-11-24-oscorp',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['nakatomi-trading-corp'],
                'name'           => 'Nakatomi Trading Corp.',
                'slug'           => 'nakatomi-trading-corp',
                'date'           => null,
                'content'        => '',
            ],
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['spacely-space-sprockets'],
                'name'           => 'Spacely Space Sprockets',
                'slug'           => '2025-11-24-spacely-space-sprockets',
                'date'           => '2025-11-24',
                'content'        => '',
            ],
        ];

        if (!empty($data)) {
            new CoverLetter()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'cover_letters');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerEvents(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Event ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'location'       => null,
                'description'    => null,
            ]
            */
        ];

        if (!empty($data)) {
            new Event()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'events');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerNotes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Note ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'body'           => null,
            ]
            */
        ];

        if (!empty($data)) {
            new Note()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'notes');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerReferences(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Reference ...\n";

        $idahoNationLabId = new Company()->where('name', 'Idaho National Laboratory')->first()->id ?? null;

        $data = [
            [ 'name' => 'George Costanza', 'slug' => 'george-costanza', 'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => null,                    'street2' => null,  'city' => 'New York',    'state_id' => 33,   'zip' => null,    'country_id' => 237, 'phone' => '(208) 555-0507', 'phone_label' => 'work',   'alt_phone' => '(208) 555-3644', 'alt_phone_label' => 'mobile', 'email' => 'kevin.hemsley@inl.gov',          'email_label' => 'work', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => null,         'link' => 'https://www.linkedin.com/in/kevin-hemsley-a30740132/' ],
            [ 'name' => 'Ron Swanson',     'slug' => 'ron-swanson',     'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => null,                    'street2' => null,  'city' => 'Pawnee',      'state_id' => 15,   'zip' => null,    'country_id' => 237, 'phone' => '(913) 555-5399', 'phone_label' => null,     'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'paul.davis@inl.gov',             'email_label' => 'work', 'alt_email' => 'prtdavis2@yahoo.com', 'alt_email_label' => 'home',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Homer Simpson',   'slug' => 'homer-simpson',   'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => '742 Evergreen Terrace', 'street2' => null,  'city' => 'Springfield', 'state_id' => null, 'zip' => null,    'country_id' => 237, 'phone' => '(917) 555-6003', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'akahen@live.com',                'email_label' => 'home', 'alt_email' => 'alen.kahen@inl.com',  'alt_email_label' => 'work',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Basil Fawlty',    'slug' => 'basil-fawlty',    'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => '16 Elwood Avenue',      'street2' => null,  'city' => 'Torquay',     'state_id' => null, 'zip' => null,    'country_id' => 237, 'phone' => '(603) 555-2707', 'phone_label' => 'mobile', 'alt_phone' => '(208) 555-4280', 'alt_phone_label' => 'work',   'email' => 'nancy.gomezdominguez@inl.gov',   'email_label' => 'work', 'alt_email' => 'ngd.00@outlook.com',  'alt_email_label' => 'home',  'birthday' => null,         'link' => null ],
            [ 'name' => 'Phil Dunphy',     'slug' => 'phil-dunphy',     'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => '10336 Dunleer Dr',      'street2' => null,  'city' => 'Los Angeles', 'state_id' => 5,    'zip' => '90064', 'country_id' => 237, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'BZearfoss@aol.com',              'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1942-08-20', 'link' => null ],
            [ 'name' => 'Al Bundy',        'slug' => 'al-bundy',        'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => '9764 Jeopardy Lane',    'street2' => null,  'city' => 'Chicago',     'state_id' => 14,   'zip' => null,    'country_id' => 237, 'phone' => '(717) 555-7795', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1415', 'alt_phone_label' => 'mobile', 'email' => 'zearfoss@verizon.net',           'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1962-07-19', 'link' => null ],
            [ 'name' => 'Herman Munster',  'slug' => 'herman-munster',  'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => '1313 Mockingbird Lane', 'street2' => null,  'city' => 'Horrorwood',  'state_id' => 5,    'zip' => null,    'country_id' => 237, 'phone' => '(775) 555-1264', 'phone_label' => 'home',   'alt_phone' => '(775) 555-0775', 'alt_phone_label' => 'mobile', 'email' => 'DZearfoss@aol.com',              'email_label' => 'home', 'alt_email' => 'dzearfoss@eigwc.com', 'alt_email_label' => 'work',  'birthday' => '1965-11-25', 'link' => null ],
            [ 'name' => 'Raymond Holt',    'slug' => 'raymond-holt',    'friend' => 0, 'family' => 1, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => '2678 East Rd',          'street2' => null,  'city' => 'Brooklyn',    'state_id' => 33,   'zip' => null,    'country_id' => 237, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => null,                             'email_label' => null,   'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1941-09-11', 'link' => null ],
            [ 'name' => 'Charlie Kelly ',  'slug' => 'charlie-kelly',   'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => '903 S. Ninth St',       'street2' => null,  'city' => 'Philadelphia','state_id' => 39,   'zip' => null,    'country_id' => 237, 'phone' => '(763) 555-2216', 'phone_label' => 'mobile', 'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'mariaelaine29@yahoo.com',        'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday' => '1980-07-30', 'link' => null ],
            [ 'name' => 'Frank Reynolds',  'slug' => 'frank-reynolds',  'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => '226 Market St',         'street2' => null,  'city' => 'Philadelphia','state_id' => 39,   'zip' => null,    'country_id' => 237, 'phone' => '(830) 555-8713', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'refugeechildrendream@yahoo.com', 'email_label' => 'home', 'alt_email' => null,                  'alt_email_label' => null,    'birthday'  => null,        'link' => null ],
        ];

        if (!empty($data)) {
            new Reference()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'references');
        }
    }

    /**
     * @return void
     */
    protected function insertCareerResumes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Resume ...\n";

        $data = [
            [ 'name' => 'Senior Software Engineer',                 'slug' => '2025-06-09-senior-software-engineer',                 'date' => '2025-06-09', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior Software Engineer',                 'slug' => '2025-06-16-senior-software-engineer',                 'date' => '2025-06-16', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior Software Engineer [condensed]',     'slug' => '2025-06-22-senior-software-engineer-[condensed]',     'date' => '2025-06-22', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior Software Engineer [streamlined]',   'slug' => '2025-06-29-senior-software-engineer-[streamlined]',   'date' => '2025-06-29', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior Full Stack Developer [prettified]', 'slug' => '2025-07-07-senior-full-stack-developer-[prettified]', 'date' => '2025-07-07', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior PHP Developer [prettified]',        'slug' => '2025-07-07-senior-php-developer-[prettified]',        'date' => '2025-07-07', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Front-end Developer [prettified]',         'slug' => '2025-07-07-front-end-developer-[prettified]',         'date' => '2025-07-07', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Front-end Developer [prettified]',         'slug' => '2025-07-22-front-end-developer-[prettified]',         'date' => '2025-07-22', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior Full Stack Developer [prettified]', 'slug' => '2025-07-22-senior-full-stack-developer-[prettified]', 'date' => '2025-07-22', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior PHP Developer [prettified]',        'slug' => '2025-07-22-senior-php-developer-[prettified]',        'date' => '2025-07-22', 'primary' => 0, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 0 ],
            [ 'name' => 'Senior Software Engineer [ai]',            'slug' => '2025-08-07-senior-software-engineer-[ai]',            'date' => '2025-08-07', 'primary' => 1, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 1 ],
            [ 'name' => 'Full Stack Developer [ai]',                'slug' => '2025-08-07-full-stack-developer-[ai]',                'date' => '2025-08-07', 'primary' => 1, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 1 ],
            [ 'name' => 'Senior Software Engineer [complete]',      'slug' => '2025-12-08-senior-software-engineer-[complete]',      'date' => '2025-12-08', 'primary' => 1, 'doc_filepath' => null, 'pdf_filepath'  => null, 'public' => 1 ],
            //[ 'name' => '',                                         'slug' => '',                                                    'date' => null,         'primary' => 0, 'doc_filepath' => null, 'pdf_filepath' => null, 'public' => 1 ],
        ];

        $resumeModel = new Resume();

        if (!empty($data)) {
            $resumeModel->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'resumes');
        }

        $this->resumes = [];
        foreach($resumeModel->withoutGlobalScope(AdminPublicScope::class)->select(['id', 'slug'])
                    ->where('owner_id', $this->adminId)->get() as $resume) {
            $this->resumes[$resume->slug] = $resume->id;
        }
    }

    /**
     * Adds timestamps, owner_id, and additional fields to each row in a data array.
     *
     * @param array $data
     * @param bool $timestamps
     * @param int|null $ownerId
     * @param array $extraColumns
     * @param bool $addDisclaimer
     * @return array
     */
    protected function additionalColumns(array    $data,
                                         bool     $timestamps = true,
                                         int|null $ownerId = null,
                                         array    $extraColumns = [],
                                         bool     $addDisclaimer = false): array
    {
        for ($i = 0; $i < count($data); $i++) {

            // timestamps
            if ($timestamps) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            // owner_id
            if (!empty($ownerId)) {
                $data[$i]['owner_id'] = $ownerId;
            }

            // extra columns
            foreach ($extraColumns as $name => $value) {
                $data[$i][$name] = $value;
            }

            if ($addDisclaimer) {
                foreach ($extraColumns as $name => $value) {
                    $data[$i]['disclaimer'] = 'This is only for site demo purposes and I do not have any ownership or relationship to it.';
                }
            }
        }

        return $data;
    }

    /**
     * Insert system database entries into the admin_databases table.
     *
     * @param int $ownerId
     * @return void
     * @throws Exception
     */
    protected function insertSystemAdminDatabase(int $ownerId): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminDatabase ...\n";

        if ($database = new Database()->where('tag', self::DB_TAG)->first()) {

            $data = [];

            $dataRow = [];

            foreach($database->toArray() as $key => $value) {
                if ($key === 'id') {
                    $dataRow['database_id'] = $value;
                } elseif ($key === 'owner_id') {
                    $dataRow['owner_id'] = $ownerId;
                } else {
                    $dataRow[$key] = $value;
                }
            }

            $dataRow['created_at']  = now();
            $dataRow['updated_at']  = now();

            $data[] = $dataRow;

            new AdminDatabase()->insert($data);
        }
    }

    /**
     * Insert system database resource entries into the admin_resources table.
     *
     * @param int $ownerId
     * @param string $tableName
     * @return void
     */
    protected function insertSystemAdminResource(int $ownerId, string $tableName): void
    {
        echo self::USERNAME . ": Inserting {$tableName} table into System\\AdminResource ...\n";

        if ($resource = new Resource()->where('database_id', $this->databaseId)->where('table', $tableName)->first()) {

            $data = [];

            $dataRow = [];

            foreach($resource->toArray() as $key => $value) {
                if ($key === 'id') {
                    $dataRow['resource_id'] = $value;
                } elseif ($key === 'owner_id') {
                    $dataRow['owner_id'] = $ownerId;
                } else {
                    $dataRow[$key] = $value;
                }
            }

            $dataRow['created_at']  = now();
            $dataRow['updated_at']  = now();

            $data[] = $dataRow;

            new AdminResource()->insert($data);
        }
    }

    /**
     * Get the database.
     */
    protected function getDatabase()
    {
        return new Database()->where('tag', self::DB_TAG)->first();
    }

    /**
     * Get the database's resources.
     *
     * @return array|Collection
     */
    protected function getDbResources(): Collection|array
    {
        if (!$database = $this->getDatabase()) {
            return [];
        } else {
            return new Resource()->where('database_id', $database->id)->get();
        }
    }
}
