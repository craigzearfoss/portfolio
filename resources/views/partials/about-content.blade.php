<div class="p-4" style="max-width: 60rem;">

    <h2 class="title">About {{ config('app.name') }}</h2>

    <div class="container show-container">
        <div class="columns is-12 is-variable">
            <div class="column is-12-tablet">

                <!-- tabbed content -->
                <div class="card tabs is-boxed mb-0" style="background-color: #f8f8f8; border-width: 0;">
                    <ul style="border-bottom-width: 0 !important;">
                        <li id="initial-selected-tab"  class="ml-1 is-active" data-target="site-overview">
                            <a>Site Overview</a>
                        </li>
                        <li class="ml-1" data-target="site-details">
                            <a>Site Details</a>
                        </li>
                        <?php /*
                        <li class="ml-1" data-target="job-search-management">
                            <a>Job Search Management</a>
                        </li>
                        */ ?>
                        <li class="ml-1" data-target="admin-preview">
                            <a>Admin Preview</a>
                        </li>
                        <li class="ml-1" data-target="dictionary">
                            <a>Dictionary</a>
                        </li>
                        <li class="mr-1" data-target="technical-overview">
                            <a>Technical Overview</a>
                        </li>
                        <li class="mr-1" data-target="roadmap">
                            <a>Roadmap</a>
                        </li>
                    </ul>
                </div>

                <div class="card px-2" id="tab-content">

                    <div id="site-overview">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Site Overview</h3>

                            <p>
                                <strong>{{ config('app.name') }}</strong> is a single place to manage your job searches
                                and career information.
                            </p>
                            <p>
                                While there are many job sites and sites to help write your resumes
                                and cover letters, the tools to manage a job search are sorely lacking which
                                forces people to still resort to Excel spreadsheets and email programs to track job
                                applications that have often been submitted to multiple job boards and corporate websites.
                            </p>
                            <p>
                                <strong>{{ config('app.name') }}</strong> allows you to keep all your job search
                                information in one place. It includes advanced search features so you can quickly access
                                information about any application you have submitted. The cover letter and resume
                                that you submitted with an application to an employer are attached to your application
                                information so you no longer have to wonder what resume or cover letter you submitted.
                            </p>
                            <p>
                                While all of you career information is private, the website also allows you to
                                add information about your projects, awards, hobbies, and skills that can be made
                                public so you can showcase them to potential employers.
                            </p>

                            @php
                                $demoUrl       = config('app.demo_site_url');
                                $demoSingleUrl = config('app.demo_single_site_url');
                            @endphp
                            @if($demoUrl || $demoSingleUrl)
                                <p>
                                    @if($demoUrl)
                                        A demonstration of this website is at <a href="{{ $demoUrl }}" target="_blank"><strong>{{ $demoUrl }}</strong></a>.
                                    @endif
                                        @if($demoSingleUrl)
                                            A demonstration of this website is at <a href="{{ $demoSingleUrl }}" target="_blank"><strong>{{ $demoSingleUrl }}</strong></a>.
                                        @endif
                                </p>
                            @endif
                            <p class="mb-0">
                                <i>
                                    "I created this site to help organize my own job search so I designed it in a
                                    that is most useful to myself. I am interested in any input about the design and
                                    additional features that would make it more useful to other users." - Craig Zearfoss
                                </i>
                            </p>

                        </div>

                    </div>
                    <div id="site-details">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Site Details</h3>

                            <p>
                                The primary purpose of <strong>{{ config('app.name') }}</strong> is to provide a single
                                place for you to track and manage all of your career and job search information.
                            </p>
                            <p>
                                The secondary purpose is to all you to manage data about your accomplishments, projects,
                                skills, hobbies, etc. to create a public profile as a showcase for potential employers.
                            </p>
                            <p>
                                What this site is <strong>NOT</strong>:
                                <div class="content">
                                    <ul style="list-style-type: circle;">
                                        <li>A job board or job recruiter website.</li>
                                        <li>A social networking website.</li>
                                        <li>A resume or cover letter creation website.</li>
                                    </ul>
                                </div>
                            </p>

                        </div>

                    </div>
                    <?php /*
                    <div id="job-search-management">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Job Search Management</h3>

                            <p><i>Coming soon.</i></p>

                        </div>

                    </div>
                    */ ?>
                    <div id="admin-preview">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Admin Preview</h3>

                            <p class="mb-5">
                                A tour of the <strong>{{ config('app.name') }}</strong> admin area is still in the works,
                                but below is sample of some of the pages to give an overview of some of the functionality.
                            </p>

                            <h3 class="is-size-5 title mb-1">Career Menu Options</h3>
                            <div class="card admin-preview" style="max-width: 50rem;">
                                <div class="admin-preview-image">
                                    <img src="/assets/tour/images/menu-career.png" alt="admin career page">
                                </div>
                                <div class="admin-preview-text">
                                    <p>
                                        The career menu options are where you manage and track your job search and career
                                        information,
                                    </p>
                                    <p>
                                        They allow you to track your job applications and record the communications
                                        and events associated with each application. You can also add notes to the
                                        application. You can attach a resume and cover letter to each application so
                                        you'll know exactly what you sent with each application.
                                    </p>
                                    <p>
                                        The career menu options also allow you to maintain a list of companies and
                                        information about them, including contacts. In addition, there is an address
                                        book for you to manage your references.
                                    </p>
                                    <p>
                                        None of the career menu options are intended to be open to the public (but
                                        you can mark any option publicly viewable if you wish).
                                    </p>
                                    <p>
                                        All of the career menu options are fully searchable allowing you easy access
                                        to specific information. To see the application search panel click
                                        <a href="#applications-listing" title="applications listing"><strong>HERE</strong></a>.
                                    </p>
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Portfolio Menu Options</h3>
                            <div class="card admin-preview" style="max-width: 50rem;">
                                <div class="admin-preview-image">
                                    <img src="/assets/tour/images/menu-portfolio.png" alt="admin portfolio page">
                                </div>
                                <div class="admin-preview-text">
                                    <p>
                                        The portfolio menu options are where you can record your accomplishments and information
                                        about your interests and hobbies. These are primarily intended for your work
                                        and career-related activities to highlight them for potential employers. Non
                                        work-related personal hobbies are generally added to the personal menu
                                        options.
                                    </p>
                                    <p>
                                        By default, all portfolio menu information is publicly accessible, but you can
                                        mark any item as private. The only exception to this are job coworkers which are
                                        private by default, but you can make any of them public.
                                    </p>
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Personal Menu Options</h3>
                            <div class="card admin-preview" style="max-width: 50rem;">
                                <div class="admin-preview-image">
                                    <img src="/assets/tour/images/menu-personal.png" alt="admin personal page">
                                </div>
                                <div class="admin-preview-text">
                                    <p>
                                        Personal menu options are where you add information for your non work-related
                                        hobbies and interests. Right now it only includes readings and recipes, but
                                        there are plans for many others.
                                    </p>
                                    <p>
                                        By default, all personal menu information is publicly available, but you
                                        can mark any information as private to prevent anyone from seeing it.
                                    </p>
                                </div>
                            </div>

                            <h3 id="applications-listing" class="is-size-5 title mb-1">Applications Listing</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This page consists of a list of all you job applications. It contains an
                                        advanced search panel so you can finely tune your searches to quickly find
                                        what you're looking for.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-index.png" alt="applications listing">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Overview</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This tab contains all of the information about a job application.
                                        There are also separate tabs for the cover letter, resume, communications,
                                        events, and notes.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-overview.png" alt="application overview">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Cover Letter</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This tab shows the submitted cover letter content and a link to the cover letter content.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-cover-letter-index.png" alt="application cover letter">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Resume</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This tab shows the name of the submitted resume and a link to the resume file.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-resume-index.png" alt="application resume">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Communications Listing</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This tab shows a list of all communications associated with the application.
                                        These communications need to be entered manually because there is no
                                        import functionality.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-communication-index.png" alt="application communication listing">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Communication View</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This page shows the details about an application communication.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-communication-show.png" alt="application communication view">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Events Listing</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p>
                                        This tab shows a list of all events associated with the application.
                                        These can include phone interviews, zoom calls, skills tests, or other events.
                                    </p>
                                    <p class="mb-0">
                                        These events need to be entered manually because there is no
                                        import functionality.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-event-index.png" alt="application events listing">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Event View</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This page shows the details about an application event.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-event-show.png" alt="application event view">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Notes Listing</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This tab shows a list of notes about the job requirements, the company,
                                        or any other information you think is important about the job application.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-note-index.png" alt="application notes listing">
                                </div>
                            </div>

                            <h3 class="is-size-5 title mb-1">Application Note View</h3>
                            <div class="card admin-preview no-flex">
                                <div class="admin-preview-text no-flex">
                                    <p class="mb-0">
                                        This page shows the details about an application note.
                                    </p>
                                </div>
                                <div class="admin-preview-image no-flex">
                                    <img src="/assets/tour/images/application-note-show.png" alt="application note view">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div id="dictionary">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Dictionary</h3>

                            <p>
                                The website also include a dictionary of technical job-related terminology. The dictionary
                                is accessible from items on both the left and top menus.
                            </p>
                            <p>
                                It has been initially created for software developers so it is very computer and network focused
                                but there are plans to make it cover a broader range of terminology.
                            </p>
                            <p>
                                Currently it contains terminology for
                                <a href="/dictionary/database">databases</a>,
                                <a href="/dictionary/framework">web frameworks</a>,
                                <a href="/dictionary/language">programming languages</a>,
                                <a href="/dictionary/library">software libraries</a>,
                                <a href="/dictionary/operating-system">operating systems</a>,
                                <a href="/dictionary/server">computing servers</a>,
                                and <a href="/dictionary/technology">technology stacks</a>.
                            </p>

                            <p>
                                Only admins with root privileges can add or edit dictionary entries.
                            </p>
                        </div>

                    </div>
                    <div id="technical-overview">

                        <div class="p-4">

                            <h3 class="is-size-5 title">Technical Overview</h3>
                            <div>
                                <p class="mt-2 mb-1">The following technologies are used on the website.</p>
                                <div class="content">
                                    <ul class="mt-0" style="list-style-type: circle;">
                                        <li><strong>Laravel 12 framework</strong></li>
                                        <li><strong>Bulma CSS</strong></li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <p class="mt-2 mb-1">The following technologies have not yet been implemented.</p>
                                <div class="content">
                                    <ul class="mt-0" style="list-style-type: circle;">
                                        <li><strong>Vue3.js</strong> - For dynamic menu system, as well as a more responsive front end design.</li>
                                        <li><strong>AG Grid</strong> - For enhanced data display and search functionality.</li>
                                        <li><strong>Redis</strong> - For caching permissions and menus.)</li>
                                    </ul>
                                </div>
                            </div>

                            <p class="mt-3">
                                The site framework supports multiple admins. Each admin has control over their own data, but cannot
                                see the data of any other admin unless that data is marked as "public". However, if an admin has root
                                privileges, they can see and edit the data of any other admin.
                            </p>
                            <p>
                                In addition to admins, the framework also supports a multiple user member area but this feature is not
                                currently being used. When it is implemented, a person will be able to request a user account that
                                will then need to be approved by a root admin.
                            </p>
                            <p>
                                This framework also allows themed templates so the site administrator can create custom templates for
                                pages without needing to modify the core template code.
                            </p>

                        </div>

                    </div>
                    <div id="roadmap">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Roadmap</h3>

                            <p>
                                Below are a list of features and/or enhancements that are to be added to the
                                <strong>{{ config('app.name') }}</strong> website. They are in no particular order.
                            </p>

                            <div class="mt-5 ml-6">
                                <h3 class="is-size-6 title mb-3">User Features</h3>
                                <div class="content">
                                    <ul style="list-style-type: circle;">
                                        <li>Add-multi factor authentication.</li>
                                        <li>Add captcha.</li>
                                        <li>Add file upload functionality.</li>
                                        <li>Make menus collapsible, probably using <strong>Vue.js</strong>.</li>
                                        <li>Implement tables with <strong>AG Grid</strong>.</li>
                                        <li>Implement skill tags for applications.</li>
                                        <li>Add type-ahead to select lists.</li>
                                        <li>Create downloadable <strong>Excel</strong> reports.</li>
                                        <li>Work on responsive design for mobile.</li>
                                        <li>Prettify the site. Possibly implement light and dark themes.
                                        </li>
                                        <li>Create a one-click method to bookmark job application webpages and import and parse the job
                                            description content.
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-5 ml-6">
                                <h3 class="is-size-6 title mb-3">Backend Functionality</h3>
                                <div class="content">
                                    <ul style="list-style-type: circle;">
                                        <li>Cache permissions and menus. (Most likely with <strong>Redis</strong>.)</li>
                                        <li>Create database backup and import scripts.</li>
                                        <li>Create an API and implement ajax calls on form pages.</li>
                                        <li>Add geo positioning trait for addresses</li>
                                        <li>Create functionality to log off other admins and users from the admin.</li>
                                        <li>Stress test the site to verify it's performance.</li>
                                        <li>Add billing. (Only if I feel the site is marketable.)</li>
                                    </ul>
                                </div>
                            </div>

                            <p>
                                In order to make this project economically feasible we will have have to offer
                                memberships. I would like to keep the price of membership as low as possible,
                                because I understand how stressful searching for jobs can be. We will determine
                                on plan of action based on user interest.
                            </p>

                            <p>
                                There are no ads on this website. There are no plans to ads to the site,
                                but if we determine adding ads will allow us to create the price of memberships
                                low we may consider it.
                            </p>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

