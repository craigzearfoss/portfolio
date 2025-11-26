@php
$admin = \App\Models\System\Admin::where('username', 'craig-zearfoss')->first();
$portfolioResources = \App\Models\System\Database::getResources('portfolio', [], ['name', 'asc']);
@endphp
@extends('guest.layouts.default', [
    'title'   => $admin->name,
    'breadcrumbs' => [],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card column p-4">

        <div class="columns">

            <div class="column is-one-third pt-0">

                @include('admin.components.image', [
                    'name'     => 'image',
                    'src'      => $admin->image,
                    'alt'      => $admin->name,
                    'width'    => '300px',
                    'filename' => getFileSlug($admin->name, $admin->image)
                ])

                <div class="show-container p-4">

                    <div class="columns">
                        <span class="column is-12 has-text-centered">
                            @include('guest.components.link', [
                                'name'   => 'Resume',
                                'href'   => route('guest.admin.resume', $admin),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                    </div>

                    @include('guest.components.show-row', [
                        'name'  => 'role',
                        'value' => $admin->role ?? ''
                    ])

                    @include('guest.components.show-row', [
                        'name'  => 'employer',
                        'value' => '<br>' . $admin->employer ?? ''
                    ])

                    @include('guest.components.show-row', [
                        'name'  => 'bio',
                        'value' => $admin->bio ?? ''
                    ])

                </div>

            </div>

            <div class="column is-two-thirds pt-0">

                <div>

                    <h1 class="title is-size-5 mt-2 mb-0">Portfolio</h1>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($portfolioResources as $resource)

                            @if(empty($resource['global']) && Route::has('guest.admin.portfolio.'.$resource['name'].'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resource['plural'],
                                        'href'  => route('guest.admin.portfolio.'.$resource['name'].'.index', $admin),
                                        'class' => 'pt-1 pb-1',
                                    ])
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <div class="column p-4">

        <div class="column has-text-centered">

            <h2 class="title p-4">Welcome to {{ config('app.name') }} Admin!</h2>

            <div class="is-flex is-align-items-center is-justify-content-center mb-4">
                <div class="box has-text-left" style="max-width: 40em;">
                    <h2 class="subtitle">About This Site</h2>
                    <p>
                        This project is a multi-user website for people to display their work portfolio and accomplishments,
                        personal projects and collections, or any other type of data. It is in the very early beta stage of development.
                    </p>
                    <p>
                        It start started out as a system to manage a job search.  If the admin area you can track your
                        job applications, resumes, and cover letter and well a many your references and company contacts.
                        You can add communications, events, and notes to all of you applications.
                    </p>
                    <p>
                        This project was created by <strong>Craig Zearfoss</strong> who can be found on LinkedIn at
                        <a href="https://www.linkedin.com/in/craig-zearfoss/" target="_blank"><strong>https://www.linkedin.com/in/craig-zearfoss/</strong></a>
                        or at his personal page at <a href="https://craigzearfoss.com" target="_blank"><strong>https://craigzearfoss.com</strong></a>.
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
