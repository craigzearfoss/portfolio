@extends('guest.layouts.default', [
    'title'   => config('app.name'),
    'breadcrumbs' => [],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card column p-4">

        <div class="column has-text-centered">

            <h1 class="title">{{ config('app.name') }}</h1>

            <div class="has-text-centered">
                <a class="is-size-6" href="{{ route('user.login') }}">
                    User Login
                </a>
                |
                <a class="is-size-6" href="{{ route('admin.login') }}">
                    Admin Login
                </a>
            </div>

        </div>

    </div>

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

                <ul class="menu-list" style="max-width: 20em;">

                    @foreach ($portfolioResources as $resource)

                        @if(empty($resource['global']) && Route::has('guest.admin.portfolio.'.$resource['name'].'.index'))
                            <li>
                                @include('guest.components.link', [
                                    'name' => $resource['plural'],
                                    'href' => route('guest.admin.portfolio.'.$resource['name'].'.index', $admin),
                                ])
                            </li>
                        @endif

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endsection
