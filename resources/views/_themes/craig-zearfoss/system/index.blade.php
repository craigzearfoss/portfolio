@extends('guest.layouts.default', [
    'title'   => $featuredAdmin ? $featuredAdmin->name : config('add.name'),
    'breadcrumbs' => [],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])
@section('content')

    <h2 class="title p-4">Welcome to {{ config('app.name') }}</h2>

    @if ($featuredAdmin)
        @include('guest.components.featured-admin', ['admin' => $featuredAdmin])
    @endif

    <div class="column p-4 mt-2">

        <div class="column has-text-centered p-0">

            <div class="is-flex is-align-items-center is-justify-content-center mb-4">
                <div class="box has-text-left" style="max-width: 40em;">
                    <h2 class="subtitle">About This Site</h2>
                    <p>
                        This project is a multi-user website for people to display their work portfolio and accomplishments,
                        personal projects, collections, or other types of data. It is in the very early beta stage of development.
                    </p>

                    @if($demoURL = config('app.demo_admin_url'))
                        <p>
                            You can visit a demo version of this project by clicking the button below.
                            <a class="button is-success"
                               target="_blank"
                               href="{{$demoURL}}"
                            >
                                Visit the demo site at {{$demoURL}}
                            </a>
                        </p>
                    @endif

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
                        that are still to be added, visit the <a href="{{route('system.about')}}"><strong>About Page</strong></a>.
                    </p>
                    <p>
                        If you would like to contact me about this project or an employment opportunity, please do it
                        through my LinkedIn page. Thanks. - <i>Craig Zearfoss</i>
                    </p>
                </div>
            </div>

            <?php /*
            <div class="has-text-centered">
                <a class="is-size-6" href="{{ route('user.login') }}">
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

@endsection
