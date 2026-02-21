@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => !empty($owner->name) ? $owner->name : $owner->username ]
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ??  !empty($owner->name) ? $owner->name : $owner->username,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
    'prev'             => $prev,
    'next'             => $next,
])

@section('content')

    @if($owner->demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container">

        <div class="show-container floating-div card">

            <div class="container">

                @include('guest.components.image', [
                    'src'      => $thisAdmin->image,
                    'width'    => '300px',
                    'download' => false,
                    'external' => false,
                    ])

                    <span class="bottom-right-span m-4 pb-2 pr-4">
                        @include('guest.components.link', [
                            'name'   => '<i class="fa fa-file-text" aria-hidden="true"></i>Resume',
                            'href'   => route('guest.resume', $owner),
                            'class'  => 'button is-primary is-small px-1 py-0',
                            'style'  => 'font-size: 1rem;',
                            'title'  => 'Resume',
                        ])
                    </span>


            </div>
            <div class="m-2 mt-3">

                @include('guest.components.show-row', [
                    'name'  => 'name',
                    'value' => $thisAdmin->name
                ])

                @include('guest.components.show-row', [
                    'name'  => 'role',
                    'value' => $thisAdmin->role
                ])

                @include('guest.components.show-row', [
                    'name'  => 'employer',
                    'value' => $thisAdmin->employer
                ])

                @if(!empty($thisAdmin->employmentStatus))
                    @include('guest.components.show-row', [
                        'name'  => 'status',
                        'value' => $thisAdmin->employmentStatus->name ?? ''
                    ])
                @endif

                @if(!empty($thisAdmin->phone))
                    @include('guest.components.show-row', [
                        'name'  => 'phone',
                        'value' => $thisAdmin->phone
                    ])
                @endif

                @include('guest.components.show-row', [
                    'name'  => 'email',
                    'value' => $thisAdmin->email
                ])

            </div>

        </div>

        @foreach($dbColumns as $title=>$resources)

            <div class="card floating-div m-2 p-4">

                <div class="card-head" style="border-bottom: #5c636a 2px outset;">
                    <strong>{{ $title }}</strong>
                </div>
                <div class="card-body">
                    <div class="list is-hoverable">
                        <ul class="menu-list" style="max-width: 20em;">

                            @foreach ($resources as $resource)

                                @if(!empty($resource->url))

                                    <li>
                                        @include('guest.components.link', [
                                            'name'  => $resource->plural,
                                            'href'  => $resource->url,
                                            'class' => 'list-item',
                                            'style' => [
                                                'padding: 0.2rem',
                                                'white-space: nowrap',
                                                'margin-left: ' . (12 * ($resource->menu_level - 1)) . 'px',
                                            ],
                                        ])
                                    </li>

                                @endif

                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

@endsection
