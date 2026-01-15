@extends('guest.layouts.default', [
    'title'            => $pageTitle ??  !empty($admin->name) ? $admin->name : $admin->username,
    'breadcrumbs'      => [
        [ 'name' => 'Home',  'href' => route('home') ],
        [ 'name' => 'Users', 'href' => route('home') ],
        [ 'name' => !empty($admin->name) ? $admin->name : $admin->username ]
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $admin->disclaimer ])

    <div class="card column p-4">

        <div class="columns">

            <div class="column is-one-third pt-0">

                @include('guest.components.image', [
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
                                'href'   => route('guest.resume', $admin),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                    </div>

                    @if(!empty($admin->role))
                        @include('guest.components.show-row', [
                            'name'  => 'role',
                            'value' => $admin->role
                        ])
                    @endif

                    @if(!empty($admin->employer))
                        @include('guest.components.show-row', [
                            'name'  => 'employer',
                            'value' => '<br>' . $admin->employer
                        ])
                    @endif

                    @if(!empty($admin->bio))
                        @include('guest.components.show-row', [
                            'name'  => 'bio',
                            'value' => $admin->bio
                        ])
                    @endif

                </div>

            </div>

            <div class="column is-two-thirds pt-0">

                @foreach($databases as $database)

                    @if (array_key_exists($database->database_id, $resources))

                        <div>

                            <h1 class="title is-size-5 mt-2 mb-0">{!! $database->title !!}</h1>

                            <ul class="menu-list ml-4 mb-2">

                                @foreach ($resources[$database->database_id] as $resource)

                                    <?php /* @TODO: We probably need to create a job Controller and templates. */ ?>
                                    @if($resource->has_owner && ($resource->guest || $resource->global) && ($resource->name != 'job'))
                                        <li style="padding-left: {{ $resource->menu_level - 2 }}em;">
                                            @if(Route::has('guest.'.$resource->database_name.'.'.$resource->name.'.index'))
                                                @include('guest.components.link', [
                                                    'name'  => $resource->plural,
                                                    'href'  => route('guest.'.$resource->database_name.'.'.$resource->name.'.index', $admin),
                                                    'class' => 'pt-1 pb-1',
                                                ])
                                            @else
                                                {!! $resource->plural !!}
                                            @endif
                                        </li>
                                    @endif

                                @endforeach

                            </ul>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    </div>

@endsection
