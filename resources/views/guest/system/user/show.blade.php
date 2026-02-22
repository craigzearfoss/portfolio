@php
    $title    = $pageTitle ??  !empty($user->name) ? $user->name : $user->username;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',  'href' => route('guest.index') ],
        [ 'name' => 'Users', 'href' => route('guest.user.index') ],
        [ 'name' => !empty($user->name) ? $user->name : $user->username ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $user->disclaimer ])

    <div class="card column p-4">

        <div class="columns">

            <div class="column is-one-third pt-0">

                @include('guest.components.image', [
                    'name'     => 'image',
                    'src'      => $user->image,
                    'alt'      => $user->name,
                    'width'    => '300px',
                    'filename' => getFileSlug($user->name, $user->image)
                ])

                <div class="show-container p-4">

                    <div class="columns">
                        <span class="column is-12 has-text-centered">
                            @include('guest.components.link', [
                                'name'   => 'Resume',
                                'href'   => route('guest.resume', $user),
                                'class'  => 'button is-primary is-small px-1 py-0',
                                'target' => '_blank',
                                'title'  => 'Resume',
                            ])
                        </span>
                    </div>

                    @if(!empty($user->role))
                        @include('guest.components.show-row', [
                            'name'  => 'role',
                            'value' => $user->role
                        ])
                    @endif

                    @if(!empty($user->employer))
                        @include('guest.components.show-row', [
                            'name'  => 'employer',
                            'value' => '<br>' . $user->employer
                        ])
                    @endif

                    @if(!empty($user->bio))
                        @include('guest.components.show-row', [
                            'name'  => 'bio',
                            'value' => $user->bio
                        ])
                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection
