<div class="p-4" style="max-width: 60rem;">

    <h2 class="title">About {{ config('app.name') }}</h2>

    <div class="container show-container">
        <div class="columns is-12 is-variable">
            <div class="column is-12-tablet">

                <!-- tabbed content -->
                <div class="card tabs is-boxed mb-0" style="background-color: #f8f8f8; border-width: 0;">
                    <ul style="border-bottom-width: 0 !important;">
                        <li class="ml-1 is-active" data-target="site-overview">
                            <a>Site Overview</a>
                        </li>
                        <li class="ml-1" data-target="site-details">
                            <a>Site Details</a>
                        </li>
                        <li class="ml-1" data-target="job-search-management">
                            <a>Job Search Management</a>
                        </li>
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
                                This project originally started as an application to manage a job search because I have found almost
                                all job websites are sorely lacking these type of features. I can't believe it's 2025 and we still
                                have to resort to Excel spreadsheets to manage a job search. This site allows you to track your
                                applications by not only recording information about the company and job description, but by
                                attaching
                                notes, communications, and events to the application.
                            </p>

                            @if($demoUrl = config('app.demo_url'))
                            <p>
                                The features to manage and track your applications are in the admin area. Since this site is
                                still in
                                development we are not allowing new admins, but the demo site allows you to view the admin area.
                                The
                                demo site is at <a href="{{$demoUrl}}"><strong>{{$demoUrl}}</strong></a>.
                            </p>
                            @endif

                            <p>
                                In addition to managing your job search, in the admin area you can add your portfolio information,
                                such as degrees, certificates, projects, employment history, etc. and control what information
                                is displayed in the public area. A module has also been added that also allows you to keep a record
                                of your personal portfolios and hobbies, such as reading list and recipes. Other modules for
                                different types of data are also being planned.
                            </p>
                            <p>
                                For more details about this site, as well as a to-do-list of work that is being done and features
                                that are still to be added, visit the <a href="{{ route('guest.about') }}"><strong>About Page</strong></a>.
                            </p>

                        </div>

                    </div>
                    <div id="site-details">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Site Details</h3>

                        </div>

                    </div>
                    <div id="job-search-management">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Job Search Management</h3>

                        </div>

                    </div>
                    <div id="admin-preview">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Admin Preview</h3>

                        </div>

                    </div>
                    <div id="dictionary">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Dictionary</h3>

                        </div>

                    </div>
                    <div id="technical-overview">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Technical Overview</h3>
                            <div>
                                <p>The following technologies are used on the website.</p>
                                <ul>
                                    <li>Laravel 12 framework</li>
                                    <li>Bulma CSS</li>
                                </ul>
                            </div>

                            <div>
                                The following technologies have not yet been implemented.
                                <ul>
                                    <li>Vue3.js - This will be used implement a dynamic menu system.</li>
                                </ul>
                            </div>

                            <p>
                                The site framework supports multiple admins. Each admin has control over their own data, but cannot
                                see the date of any other admin unless that data is marked as "public". However, if an admin has root
                                privileges they can see and edit the data of any other admin.
                            </p>
                            <p>
                                In addition to admins, the framework also supports a multiple user member area but this feature is not
                                currently being used. When it is implemented, a person will be able to request a user account that
                                will need to be approved by a root admin.
                            </p>
                            <p>
                                This framework also allows themed template so the site administrator can create custom templates for
                                pages without needing to modify the core templates.
                            </p>

                        </div>

                    </div>
                    <div id="roadmap">

                        <div class="p-4">

                            <h3 class="is-size-5 title mb-3">Roadmap</h3>

                            <div class="content">

                                <ul style="list-style-type: circle;">
                                    <li>Unit test all admin create/edit/delete functionality for all resources.</li>
                                    <li>Create database backup and import scripts.</li>
                                    <li>Add captcha.</li>
                                    <li>Add multi factor authentication.</li>
                                    <li>Add file upload functionality.</li>
                                    <li>Make the menus more dynamic with collapsable menu items, probably using Vue.js</li>
                                    <li>Implement tables with AG Grid.</li>
                                    <li>Implement skill tags for applications.</li>
                                    <li>Add validation to "label" field for admins and users tables.</li>
                                    <li>Create an API and start implement ajax calls on form pages.</li>
                                    <li>Add geo positioning trait for addresses</li>
                                    <li>Add enhanced search capabilities and data filtering.</li>
                                    <li>Cache user/admin permissions and menus. (Most likely with Redis)</li>
                                    <li>Allow admins/users to be logged off with the requires_login column.</li>
                                    <li>Create a way to log out all users and/or admins, probably through a console command.</li>
                                    <li>Add type-ahead to select lists.</li>
                                    <li>Create downloadable Excel reports.</li>
                                    <li>Completely implement responsive design for mobile.</li>
                                    <li>Work of the site styles to make it look pretty. Possibly implement light and dark themes.
                                    </li>
                                    <li>Create a one-click method to bookmark job application webpages and import and parse the job
                                        description content.
                                    </li>
                                    <li>Stress test the site to verify it's performance.</li>
                                    <li>Add billing. (Only if I feel the site is marketable.)</li>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
