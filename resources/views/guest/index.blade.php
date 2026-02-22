@php
    $title    = $pageTitle ?? ($featuredAdmin ? $featuredAdmin->name : config('add.name'));
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <div class="column has-text-centered">
        <h2 class="title p-2 mb-2">Welcome to {{ config('app.name') }} Admin!</h2>
    </div>

    <div class="floating-div-container" style=" max-width: 100% !important;">

        <div class="show-container card floating-div" style="max-width: 40rem;">

            <h2 class="subtitle">About This Site</h2>
            <p>
                This project is a multi-user website for people to display their work portfolio and accomplishments,
                personal projects, collections, or other types of data. It is in the very early beta stage of development.
            </p>
            <p>
                It started out as a system to manage a job search.  In the admin area you can track your
                job applications, resumes, and cover letter as well a many your references and company contacts.
                You can add communications, events, and notes to all of you applications.
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

        <div class="show-container card floating-div" style="max-width: 40rem;">

            <h4 class="title is-size-4 mb-2">Candidates</h4>
            @include('guest.components.candidates-table-narrow', ['candidates' => $admins])

        </div>

    </div>

@endsection
