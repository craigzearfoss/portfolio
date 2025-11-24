@extends('guest.layouts.default', [
    'pageTitle'   => 'About Us',
    'title'       => '',
    'subtitle'    => null,
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('system.index')],
        [ 'name' => 'About Us']
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <h2 class="title">About Us</h2>

        <div class="is-flex is-align-items-center is-justify-content-center mb-4">
            <div class="box" style="max-width: 40em;">
                <h2 class="subtitle">Site Overview</h2>
                <p>
                    This project originally started as an application to manage a job search because I have found almost
                    all job websites are sorely lacking these type of features. I can't believe it's 2025 and we still
                    have to resort to Excel spreadsheets to manage a job search. This site allows you to track your
                    applications by not only recording information about the company and job description, but by attaching
                    notes, communications, and events to the application.
                </p>
                <p>
                    The features to manage and track your applications are in the admin area. Since this site is still in
                    development we are not allowing new admins, but the demo site allows you to view the admin area. The
                    demo site is at <a href="https://demo.craigzearfoss.com"><strong></strong>https://demo.craigzearfoss.com</strong></a>.
                </p>
                <p>
                    In addition to managing your job search, in the admin area you can add your portfolio information,
                    such as degrees, certificates, projects, employment history, etc. and control what information
                    is displayed in the public area. A module has also been added that also allows you to keep a record
                    of your personal portfolios and hobbies, such as reading list and recipes. Other modules for
                    different types of data are also being planned.
                </p>
                <p>
                    For more details about this site, as well as a to-do-list of work that is being done and features
                    that are still to be added, visit the <a href="{{route('system.about')}}"><strong>About Page</strong></a>.
                </p>
            </div>
        </div>

        <div class="is-flex is-align-items-center is-justify-content-center mb-4">
            <div class="box" style="max-width: 40em;">
                <h2 class="subtitle">Technical Overview</h2>
                <p>
                    This site is written in Laravel 12. It is using Bulma for the CSS. Once the core functionality
                    is all in place the web interface will be made more dynamic. The plan is to use Vue.js 3 for
                    that. Before that can be done an API will need to be created,
                </p>
                <p>
                    The site supports multiple admins. Each admin has control over their own data and cannot see
                    another user's data, unless they have it marked as public. An admin that has root privileges
                    can see and edit any other admin's data.
                </p>
                <p>
                    There is also a multi-member user area, but there are currently no plans on what I'll be using
                    that for. A person can request a user account on the site, but admins need to be created by
                    a root admin. Since the site is in early beta development we are not currently accepting new
                    admins or users
                </p>
                <p>
                    The site allows themes so you can control the display of content of any page without modifying
                    the core templates.
                </p>
            </div>
        </div>

        <div class="is-flex is-align-items-center is-justify-content-center mb-4">
            <div class="box" style="max-width: 40em;">
                <h2 class="subtitle">To-do List</h2>
                <ul style="list-style-type: circle;">
                    <li>Verify add/edit/delete functionality works for all current resources.</li>
                    <li>Create database backup and import scripts.</li>
                    <li>Add captcha to contact, request account, and login pages.</li>
                    <li>Add file upload functionality.</li>
                    <li>Make the menus dynamic, probably using Vue.js</li>
                    <li>Implement skill tags for applications.</li>
                    <li>Create an API.</li>
                    <li>Make the pages more dynamic.</li>
                    <li>Enhance search capabilities.</li>
                    <li>Hide Create/Edit/Delete buttons if the user does not have the proper permissions.</li>
                    <li>Add a Current Admins/Users pages for root admins using the sessions table.</li>
                    <li>Allow admins/users to be logged off with the requires_login column.</li>
                    <li>Create a way to log out all users and/or admins, probably through a console command.</li>
                    <li>Completely implement responsive design for mobile.</li>
                    <li>Work of the site styles to make it look pretty. Possibly implement light and dark themes.</li>
                    <li>Create a one-click method to bookmark job application webpages and import the job description text.</li>
                    <li>Stress test the site to verify it's performance.</li>
                </ul>

            </div>
        </div>

    </div>

@endsection
