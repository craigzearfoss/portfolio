@extends('guest.layouts.default', [
    'title' => $title ?? !empty($admin->name) ? $admin->name : $admin->username,
    'breadcrumbs' => [
        [ 'name' => 'Home',  'href' => route('system.index') ],
        [ 'name' => 'Users', 'href' => route('guest.admin.index') ],
        [ 'name' => !empty($admin->name) ? $admin->name : $admin->username ]
    ],
    'buttons' => [],
    'errorMessages' => $errors->messages()  ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $admin->disclaimer ?? null ])

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

                <div>

                    <h1 class="title is-size-5 mt-2 mb-0">Personal</h1>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($personalResources as $resource)

                            @if(empty($resource['global']) && Route::has('guest.admin.personal.'.$resource['name'].'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name' => $resource['plural'],
                                        'href' => route('guest.admin.personal.'.$resource['name'].'.index', $admin),
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

@endsection
