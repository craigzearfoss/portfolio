@php
    $title    = $pageTitle ?? ($featuredAdmin ? $featuredAdmin->name : config('add.name')) . ' Demo Site';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <h2 class="title p-2 mb-2">Welcome to {{ config('app.name') }}!</h2>

    @if ($featuredAdmin)
        @include('guest.components.featured-admin', [
            'featuredAdmin' => $featuredAdmin,
            'title'         => 'Featured Candidate',
        ])
    @endif

    <div class="floating-div-container" style=" max-width: 100% !important;">
        @include('guest.components.partials.site-intro')
    </div>

    <div class="floating-div-container" style=" max-width: 100% !important;">

        <div class="show-container card floating-div" style="max-width: 60rem;">

            <h2 class="subtitle">About This Site</h2>
            <p>
                This project is multi-user website for managing a job search.
                It allows you to track your applications, record your communications, and manage your cover letters and resumes.
            </p>
            <p>
                In addition, it serves as a single point to track of your jobs, coworkers, references, projects, skills, hobbies, and much more.
                You can also choose which information you want to make publicly available so you can customize what you present to potential employers.
            </p>
            <p>
                This project is in an early beta stage.
                If you would like to learn more about it visit the <strong><a href="/about" target="blank">About Page</a></strong> for more information.
            </p>
            <p>
                This project was created by <strong>Craig Zearfoss</strong> who can be found on LinkedIn at
                <strong><a href="https://www.linkedin.com/in/craig-zearfoss/" target="_blank">https://www.linkedin.com/in/craig-zearfoss/</a></strong>
                or on his personal page at <strong><a href="https://zearfoss.com" target="_blank">https://zearfoss.com</a></strong>
            </p>
            <p>
                Feel free to contact Craig about this project or if you have potential employment opportunities for him.
            </p>
            <p>
                Thanks. <i>– Craig Zearfoss</i>
            </p>

        </div>

    </div>



    @if ($admins->currentPage() == 1)

        <div class="column p-4">

            <div class="column has-text-centered">

                <h2 class="title p-2 mb-2">Welcome to {{ config('app.name') }} Demo Site!</h2>

                <div class="is-flex is-align-items-center is-justify-content-center mb-2">
                    <div class="box has-text-left" <?php /* style="max-width: 40em;" */ ?>>
                        <h2 class="subtitle">About This Site</h2>
                        <p>
                            This project is a multi-user website for people to display their work portfolio and accomplishments,
                            personal projects, collections, or other types of data. It is in the very early beta stage of development.
                        </p>
                        <p>
                            It started out as a system to manage a job search.  In the admin area you can track your
                            job applications, resumes, as cover letter and well a many your references and company contacts.
                            You can add communications, events, and notes to all of you applications.
                        </p>
                        <p>
                            You can log in as the demo admin to view to view all of the career and application tracking pages
                            by clicking the button below.
                            <br>
                            <span class="has-text-centered" style="display: block;">
                                <a class="button is-success" href="/admin/login">Log in as the Demo Admin</a>
                            </span>
                            <br>
                            You will be able to view all of the admin pages but not update any of the site data.
                        </p>
                        <p>
                            This project was created by <strong>Craig Zearfoss</strong> who can be found on LinkedIn at
                            <a href="https://www.linkedin.com/in/craig-zearfoss/" target="_blank"><strong>https://www.linkedin.com/in/craig-zearfoss/</strong></a>
                            or at his personal page at <a href="https://zearfoss.com" target="_blank"><strong>https://zearfoss.com</strong></a>.
                        </p>
                        <p>
                            For more details about this site, as well as a to-do-list of work that is being done and features
                            that are still to be added, visit the <a href="{{ route('guest.about') }}"><strong>About Page</strong></a>.
                        </p>
                        <p>
                            If you would like to contact me about this project or an employment opportunity, please do it
                            through my LinkedIn page. Thanks. - <i>Craig Zearfoss</i>
                        </p>
                    </div>
                </div>

                <?php /*
                <div class="has-text-centered">
                    <a class="is-size-6" href="{{ route('admin.login') }}">
                        User Login
                    </a>
                    |
                    <a class="is-size-6" href="{{ route('admin.login') }}">
                        Admin Login
                    </a>
                </div>
                */ ?>

            </div>

        </div>

    @endif

    <div class="card p-4">

        <h4 class="title is-size-4">Candidates</h4>
        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th></th>
                <th>name</th>
                <th>role</th>
                <th>employer</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th style="white-space: nowrap;">user name</th>
                <th>name</th>
                <th>team</th>
                <th>email</th>
                <th>status</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($admins as $thisAdmin)

                <tr data-id="{{ $thisAdmin->id }}">
                    <td data-field="thumbnail" style="width: 40px;">
                        @if(!empty($thisAdmin->thumbnail))
                            @include('guest.components.link', [
                                'name' => view('guest.components.image', [
                                                'src'      => $thisAdmin->thumbnail,
                                                'alt'      => 'profile image',
                                                'width'    => '40px',
                                                'filename' => $thisAdmin->thumbnail
                                            ]),
                                'href' => route('guest.admin.show', $thisAdmin),
                            ])
                        @endif
                    </td>
                    <td data-field="name">
                        @include('guest.components.link', [
                            'name' => !empty($thisAdmin->name) ? $thisAdmin->name : $thisAdmin->username,
                            'href' => route('guest.admin.show', $thisAdmin),
                        ])
                    </td>
                    <td data-field="role">
                        {{ $thisAdmin->role ?? '' }}
                    </td>
                    <td data-field="employer">
                        {{ $thisAdmin->employer ?? '' }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no users.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $admins->links('vendor.pagination.bulma') !!}

    </div>

@endsection
