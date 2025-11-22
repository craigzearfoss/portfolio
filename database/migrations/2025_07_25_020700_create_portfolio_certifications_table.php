<?php

use App\Models\Portfolio\Certification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('abbreviation', 50)->nullable();
            $table->foreignIdFor(\App\Models\Portfolio\CertificationType::class, 'certification_type_id');
            $table->string('organization')->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_small', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'name' => 'Certified Business Analysis Professional',                'slug' => 'certified-business-analysis-professional',                'abbreviation' => 'CBAP',     'certification_type_id' => 1,  'link' => 'https://www.iiba.org/business-analysis-certifications/cbap/', 'organization' => 'International Institute of Business Analysis' ],
            [ 'name' => 'IIBA Agile Analysis Certification',                       'slug' => 'iiba-agile-analysis-certification',                       'abbreviation' => 'IIBA-AAC', 'certification_type_id' => 1,  'link' => 'https://www.iiba.org/business-analysis-certifications/agile-analysis/', 'organization' => 'International Institute of Business Analysis' ],
            [ 'name' => 'Certified Ethical Hacker',                                'slug' => 'certified-ethical-hacker',                                'abbreviation' => 'CEH',      'certification_type_id' => 2,  'link' => null, 'organization' => null ],
            [ 'name' => 'Google Cybersecurity Professional',                       'slug' => 'google-cybersecurity-professional',                       'abbreviation' => null,       'certification_type_id' => 2,  'link' => 'https://www.coursera.org/google-certificates/cybersecurity-certificate', 'organization' => 'Google' ],
            [ 'name' => 'Security+',                                               'slug' => 'security-plus',                                           'abbreviation' => null,       'certification_type_id' => 2,  'link' => null, 'organization' => 'CompTIA' ],
            [ 'name' => 'AWS Certified Data Analytics',                            'slug' => 'aws-certified-data-analytics',                            'abbreviation' => null,       'certification_type_id' => 3,  'link' => null, 'organization' => 'AWS' ],
            [ 'name' => 'Certified Analytics Professional',                        'slug' => 'certified-analytics-professional',                        'abbreviation' => 'CAP',      'certification_type_id' => 3,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Data Scientist',                                'slug' => 'certified-data-scientist',                                'abbreviation' => 'CDS',      'certification_type_id' => 3,  'link' => null, 'organization' => null ],
            [ 'name' => 'Google Cloud Professional Data Engineer',                 'slug' => 'google-cloud-professional-data-engineer',                 'abbreviation' => null,       'certification_type_id' => 3,  'link' => null, 'organization' => 'Google' ],
            [ 'name' => 'Certified Financial Planner',                             'slug' => 'certified-financial-planner',                             'abbreviation' => 'CFP',      'certification_type_id' => 4,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Fraud Examiner',                                'slug' => 'certified-fraud-examiner',                                'abbreviation' => 'CFE',      'certification_type_id' => 4,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Internal Auditor',                              'slug' => 'certified-internal-auditor',                              'abbreviation' => 'CIA',      'certification_type_id' => 4,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Management Accountant',                         'slug' => 'certified-management-accountant',                         'abbreviation' => 'CMA',      'certification_type_id' => 4,  'link' => 'https://www.imanet.org/ima-certifications/cma-certification', 'organization' => 'The Association of Accountants and Financial Professionals in Business' ],
            [ 'name' => 'Certified Public Accountant',                             'slug' => 'certified-public-accountant',                             'abbreviation' => 'CPA',      'certification_type_id' => 4,  'link' => 'https://nasba.org/exams/cpaexam/', 'organization' => 'National Association of State Boards of Accountancy' ],
            [ 'name' => 'Certified Treasury Professional',                         'slug' => 'certified-treasury-professional',                         'abbreviation' => 'CTP',      'certification_type_id' => 4,  'link' => null, 'organization' => null ],
            [ 'name' => 'Chartered Accountant',                                    'slug' => 'chartered-accountant',                                    'abbreviation' => 'CA',       'certification_type_id' => 4,  'link' => null, 'organization' => null ],
            [ 'name' => 'Chartered Financial Analyst',                             'slug' => 'chartered-financial-analyst',                             'abbreviation' => 'CFA',      'certification_type_id' => 4,  'link' => 'https://www.cfainstitute.org/programs/cfa-program', 'organization' => 'CFA Institute' ],
            [ 'name' => 'Financial Risk Manager',                                  'slug' => 'financial-risk-manager',                                  'abbreviation' => 'FRM',      'certification_type_id' => 4,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Dental Assistant',                              'slug' => 'certified-dental-assistant',                              'abbreviation' => 'CDA',      'certification_type_id' => 5,  'link' => 'https://www.danb.org/exams/exam/cda-exam', 'organization' => 'Dental Assisting National Board' ],
            [ 'name' => 'Certified Healthcare Information Systems Security Practitioner', 'slug' => 'certified-healthcare-information-systems-security-practitioner', 'abbreviation' => 'CHISSP', 'certification_type_id' => 5, 'link' =>null, 'organization' => null ],
            [ 'name' => 'Certified Medical Assistant',                             'slug' => 'certified-medical-assistant',                             'abbreviation' => 'CMA',      'certification_type_id' => 5,  'link' => null,'organization' => null ],
            [ 'name' => 'Certified Occupational Therapy Assistant',                'slug' => 'certified-occupational-therapy-assistant',                'abbreviation' => 'COTA',     'certification_type_id' => 5,  'link' => null,'organization' => null ],
            [ 'name' => 'Certified Pharmacy Technician',                           'slug' => 'certified-pharmacy-technician',                           'abbreviation' => 'CPhT',     'certification_type_id' => 5,  'link' => null,'organization' => null ],
            [ 'name' => 'Certified Professional Coder',                            'slug' => 'certified-professional-coder',                            'abbreviation' => 'CPC',      'certification_type_id' => 5,  'link' => null,'organization' => null ],
            [ 'name' => 'Certified Professional in Healthcare Quality',            'slug' => 'certified-professional-in-healthcare-quality',            'abbreviation' => 'CPHQ',     'certification_type_id' => 5,  'link' => null,'organization' => null ],
            [ 'name' => 'Certified Registered Nurse Anesthetist',                  'slug' => 'certified-registered-nurse-anesthetist',                  'abbreviation' => 'CRNA',     'certification_type_id' => 5,  'link' => null,'organization' => null ],
            [ 'name' => 'Certified Surgical Technologist',                         'slug' => 'certified-surgical-technologist',                         'abbreviation' => 'CST',      'certification_type_id' => 5,  'link' => 'https://www.nbstsa.org/cst-certification', 'organization' => 'The National Board of Surgical Technology and Surgical Assisting' ],
            [ 'name' => 'Emergency Medical Technician',                            'slug' => 'emergency-medical-technician',                            'abbreviation' => 'EMT',      'certification_type_id' => 5,  'link' => null, 'organization' => null ],
            [ 'name' => 'Fellow of the American College of Healthcare Executives', 'slug' => 'fellow-of-the-american-college-of-healthcare-executives', 'abbreviation' => 'FACHE',    'certification_type_id' => 5,  'link' => null, 'organization' => null ],
            [ 'name' => 'Licensed Practical Nurse',                                'slug' => 'licensed-practical-nurse',                                'abbreviation' => 'LPN',      'certification_type_id' => 5,  'link' => null, 'organization' => null ],
            [ 'name' => 'Medical Laboratory Scientist ',                           'slug' => 'medical-laboratory-scientist-',                           'abbreviation' => 'MLS',      'certification_type_id' => 5,  'link' => null, 'organization' => null ],
            [ 'name' => 'Medical Laboratory Technician',                           'slug' => 'medical-laboratory-technician',                           'abbreviation' => 'MLT',      'certification_type_id' => 5,  'link' => null, 'organization' => null ],
            [ 'name' => 'Physical Therapist Assistant',                            'slug' => 'physical-therapist-assistant',                            'abbreviation' => 'PTA',      'certification_type_id' => 5,  'link' => null, 'organization' => null ],
            [ 'name' => 'Registered Dietitian Nutritionist',                       'slug' => 'registered-dietitian-nutritionist',                       'abbreviation' => 'RDN',      'certification_type_id' => 5,  'link' => null, 'organization' => null ],
            [ 'name' => 'Associate Professional in Human Resources',               'slug' => 'associate-professional-in-human-resources',               'abbreviation' => 'aPHR',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Compensation Professional',                     'slug' => 'certified-compensation-professional',                     'abbreviation' => 'CCP',      'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Labor Relations Professional',                  'slug' => 'certified-labor-relations-professional',                  'abbreviation' => 'CLRP',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Professional in Talent Development',            'slug' => 'certified-professional-in-talent-development',            'abbreviation' => 'CPTD',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Global Professional in Human Resources',                  'slug' => 'global-professional-in-human-resources',                  'abbreviation' => 'GPHR',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Human Resources Business Professional',                   'slug' => 'human-resources-business-professional',                   'abbreviation' => 'HRBP',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Human Resources Management Professional',                 'slug' => 'human-resources-management-professional',                 'abbreviation' => 'HRMP',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'International Public Management Association for Human Resources', 'slug' => 'international-public-management-association-for-human-resources', 'abbreviation' => 'IPMA-CP', 'certification_type_id' => 6, 'link' => null, 'organization' => null ],
            [ 'name' => 'Professional in Employee Benefits',                       'slug' => 'professional-in-employee-benefits',                       'abbreviation' => 'CEBS',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Professional in Human Resources',                         'slug' => 'professional-in-human-resources',                         'abbreviation' => 'PHR',      'certification_type_id' => 6,  'link' => 'https://www.hrci.org/certifications/individual-certifications/phr', 'organization' => 'HR Certification Institute' ],
            [ 'name' => 'Professional in Human Resources - International',         'slug' => 'professional-in-human-resources-international',           'abbreviation' => 'PHRi',     'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Professional in Human Resources in California',           'slug' => 'professional-in-human-resources-in-california',           'abbreviation' => 'PHR-CA',   'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Senior Professional in Human Resources',                  'slug' => 'senior-professional-in-human-resources',                  'abbreviation' => 'SPHR',     'certification_type_id' => 6,  'link' => 'https://www.hrci.org/certifications/individual-certifications/sphr', 'organization' => 'HR Certification Institute' ],
            [ 'name' => 'Senior Professional in Human Resources in California',    'slug' => 'senior-professional-in-human-resources-in-california',    'abbreviation' => 'SPHR-CA',  'certification_type_id' => 6,  'link' => null, 'organization' => null ],
            [ 'name' => 'Society for Human Resource Management Certified Professional', 'slug' => 'society-for-human-resource-management-certified-professional', 'abbreviation' => 'SHRM-CP', 'certification_type_id' => 6, 'link' => null, 'organization' => null ],
            [ 'name' => 'Society for Human Resource Management Senior Certified Professional', 'slug' => 'society-for-human-resource-management-senior-certified-professional', 'abbreviation' => 'SHRM-SCP', 'certification_type_id' => 6, 'link' => null, 'organization' => null ],
            [ 'name' => 'Cisco Certified Internetwork Expert',                     'slug' => 'cisco-certified-internetwork-expert',                     'abbreviation' => 'CCIE',     'certification_type_id' => 7,  'link' => 'https://www.cisco.com/site/us/en/learn/training-certifications/certifications/enterprise/ccie-enterprise-infrastructure/index.html', 'organization' => '	Cisco' ],
            [ 'name' => 'Cisco Certified Network Associate',                       'slug' => 'cisco-certified-network-associate',                       'abbreviation' => 'CCNA',     'certification_type_id' => 7,  'link' => null, 'organization' => 'Cisco' ],
            [ 'name' => 'Cisco Certified Network Professional',                    'slug' => 'cisco-certified-network-professional',                    'abbreviation' => 'CCNP',     'certification_type_id' => 7,  'link' => 'https://www.cisco.com/site/us/en/learn/training-certifications/certifications/professional/index.html', 'organization' => 'Cisco' ],
            [ 'name' => 'AWS Certified Solutions Architect',                       'slug' => 'aws-certified-solutions-architect',                       'abbreviation' => null,       'certification_type_id' => 7,  'link' => null, 'organization' => 'AWS' ],
            [ 'name' => 'Certified Cloud Security Professional',                   'slug' => 'certified-cloud-security-professional',                   'abbreviation' => 'CCSP',     'certification_type_id' => 7,  'link' => null, 'organization' => 'AWS' ],
            [ 'name' => 'Certified Information Security Manager',                  'slug' => 'certified-information-security-manager',                  'abbreviation' => 'CISM',     'certification_type_id' => 7,  'link' => null, 'organization' => 'Information Systems Audit and Control Association' ],
            [ 'name' => 'Certified Information Systems Auditor',                   'slug' => 'certified-information-systems-auditor',                   'abbreviation' => 'CISA',     'certification_type_id' => 7,  'link' => null, 'organization' => 'Information Systems Audit and Control Association' ],
            [ 'name' => 'Certified Information Systems Security Professional',     'slug' => 'certified-information-systems-security-professional',     'abbreviation' => 'CISSP',    'certification_type_id' => 7,  'link' => null, 'organization' => 'International Information System Security Certification Consortium' ],
            [ 'name' => 'Certified Technology Associate',                          'slug' => 'certified-technology-associate',                          'abbreviation' => null,       'certification_type_id' => 7,  'link' => null, 'organization' => 'System Applications and Products in Data Processing' ],
            [ 'name' => 'Cisco Certified Internetwork Expert (CCIE) Data Center',  'slug' => 'cisco-certified-internetwork-expert-(ccie)-data-center',  'abbreviation' => null,       'certification_type_id' => 7,  'link' => null, 'organization' => 'Cisco' ],
            [ 'name' => 'Cloud Essentials+',                                       'slug' => 'cloud-essentials-plus',                                   'abbreviation' => null,       'certification_type_id' => 7,  'link' => null, 'organization' => 'CompTIA' ],
            [ 'name' => 'Cloud+',                                                  'slug' => 'cloud-plus',                                              'abbreviation' => null,       'certification_type_id' => 7,  'link' => null, 'organization' => 'CompTIA' ],
            [ 'name' => 'Desktop Advanced Support Technician',                     'slug' => 'desktop-advanced-support-technician',                     'abbreviation' => 'HDI-DAST', 'certification_type_id' => 7,  'link' => null, 'organization' => 'Help Desk Institute' ],
            [ 'name' => 'Google Data Analytics Professional',                      'slug' => 'google-data-analytics-professional',                      'abbreviation' => null,       'certification_type_id' => 7,  'link' => 'https://www.coursera.org/google-certificates/data-analytics-certificate', 'organization' => 'Google' ],
            [ 'name' => 'Google IT Support Professional',                          'slug' => 'google-it-support-professional',                          'abbreviation' => null,       'certification_type_id' => 7,  'link' => 'https://www.coursera.org/google-certificates/it-support-certificate', 'organization' => 'Google' ],
            [ 'name' => 'Google UX Design Professional',                           'slug' => 'google-ux-design-professional',                           'abbreviation' => null,       'certification_type_id' => 7,  'link' => 'https://www.coursera.org/google-certificates/ux-design-certificate', 'organization' => 'Google' ],
            [ 'name' => 'HDI Technical Support Professional',                      'slug' => 'hdi-technical-support-professional',                      'abbreviation' => 'HDI-TSP',  'certification_type_id' => 7,  'link' => null, 'organization' => 'Help Desk Institute' ],
            [ 'name' => 'VMware Certified Professional 6 - Data Center Visualization', 'slug' => 'vmware-certified-professional-6-data-center-visualization', 'abbreviation' => 'VCP6-DCV', 'certification_type_id' => 7, 'link' => null, 'organization' => null ],
            [ 'name' => 'Google Digital Marketing & E-commerce Professional',      'slug' => 'google-digital-marketing-&-e-commerce-professional',      'abbreviation' => null,       'certification_type_id' => 8,  'link' => 'https://www.coursera.org/google-certificates/digital-marketing-certificate', 'organization' => null ],
            [ 'name' => 'Meta',                                                    'slug' => 'meta',                                                    'abbreviation' => null,       'certification_type_id' => 8,  'link' => 'https://www.facebook.com/business/learn/certification', 'organization' => 'Meta' ],
            [ 'name' => 'Meta Certified Business Marketing Strategy',              'slug' => 'meta-certified-business-marketing-strategy',              'abbreviation' => null,       'certification_type_id' => 8,  'link' => 'https://www.facebook.com/business/learn/certification/exams/800-101-exam', 'organization' => null ],
            [ 'name' => 'Certified Agile Practitioner',                            'slug' => 'certified-agile-practitioner',                            'abbreviation' => 'PMI-ACP',  'certification_type_id' => 9,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Associate in Project Management ',              'slug' => 'certified-associate-in-project-management-',              'abbreviation' => 'CAPM',     'certification_type_id' => 9,  'link' => 'https://www.pmi.org/certifications/certified-associate-capm', 'organization' => 'Project Management Institute' ],
            [ 'name' => 'Certified Project Management Professional',               'slug' => 'certified-project-management-professional',               'abbreviation' => 'CPMP',     'certification_type_id' => 9,  'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Scrum Master',                                  'slug' => 'certified-scrum-master',                                  'abbreviation' => 'CSM',      'certification_type_id' => 9,  'link' => null, 'organization' => null ],
            [ 'name' => 'Google Project Management Professional',                  'slug' => 'google-project-management-professional',                  'abbreviation' => null,       'certification_type_id' => 9,  'link' => 'https://www.coursera.org/google-certificates/project-management-certificate', 'organization' => 'Google' ],
            [ 'name' => 'Meta Certified Community Management',                     'slug' => 'meta-certified-community-management',                     'abbreviation' => null,       'certification_type_id' => 9,  'link' => 'https://www.facebook.com/business/learn/certification/exams/600-101-exam', 'organization' => 'Meta' ],
            [ 'name' => 'Project Management Professional',                         'slug' => 'project-management-professional',                         'abbreviation' => 'PMP',      'certification_type_id' => 9,  'link' => 'https://www.pmi.org/certifications/project-management-pmp', 'organization' => 'Project Management Institute' ],
            [ 'name' => 'Associate Constructor',                                   'slug' => 'associate-constructor',                                   'abbreviation' => 'AC',       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'Building Codes and Standards',                            'slug' => 'building-codes-and-standards',                            'abbreviation' => 'BC',       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Lead Carpenter',                                'slug' => 'ertified-lead-carpenter',                                 'abbreviation' => 'CLC',      'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Remodeler',                                     'slug' => 'certified-remodeler',                                     'abbreviation' => 'CR',       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'Certified Remodeling Project Manager',                    'slug' => 'certified-remodeling-project-manager',                    'abbreviation' => 'CRPM',     'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'EPA Amusement Operators Safety',                          'slug' => 'epa-amusement-operators-safety',                          'abbreviation' => null,       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'Graduate Master Builder',                                 'slug' => 'graduate-master-builder',                                 'abbreviation' => null,       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'National Wood Flooring Association Certified Artisan',    'slug' => 'national-wood-flooring-association-certified-artisan',    'abbreviation' => null,       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'National Wood Flooring Association Certified Installer',  'slug' => 'national-wood-flooring-association-certified-installer',  'abbreviation' => null,       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'OSHA 30',                                                 'slug' => 'osha-30',                                                 'abbreviation' => null,       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'OSHA 30 Hour Construction',                               'slug' => 'osha-30-hour-construction',                               'abbreviation' => null,       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'Registered Construction Inspector in Building',           'slug' => 'registered-construction-inspector-in-building',           'abbreviation' => null,       'certification_type_id' => 10, 'link' => null, 'organization' => null ],
            [ 'name' => 'Certified in Logistics, Transportation and Distribution', 'slug' => 'certified-in-logistics,-transportation-and-distribution', 'abbreviation' => 'CLTD',     'certification_type_id' => 11, 'link' => 'https://www.ascm.org/learning-development/certifications-credentials/cltd/', 'organization' => 'Association for Supply Chain Management' ],
            [ 'name' => 'Certified in Production and Inventory Management',        'slug' => 'certified-in-production-and-inventory-management-',       'abbreviation' => 'CPIM',     'certification_type_id' => 11, 'link' => 'https://www.ascm.org/learning-development/certifications-credentials/cpim/', 'organization' => 'Association for Supply Chain Management' ],
            [ 'name' => 'Certified Supply Chain Professional',                     'slug' => 'certified-supply-chain-professional',                     'abbreviation' => 'CSCP',     'certification_type_id' => 11, 'link' => 'https://www.ascm.org/learning-development/certifications-credentials/cscp/', 'organization' => 'Association for Supply Chain Management' ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['public'] = 1;
            $data[$i]['root'] = 1;
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Certification::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('certifications');
    }
};
