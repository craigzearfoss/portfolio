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

    <h2 class="title p-2 mb-2">Craig Zearfoss Portfolio</h2>

    @if ($featuredAdmin)
        @include('guest.components.featured-admin', ['featuredAdmin' => $featuredAdmin])
    @endif

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

@endsection
