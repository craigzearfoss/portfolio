@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = $pageTitle ??  !empty($owner->name) ? $owner->name : $owner->username;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => !empty($owner->name) ? $owner->name : $owner->username ]
          ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container">

        <div class="show-container floating-div card">

            <div class="container">

                @include('guest.components.image', [
                    'src'      => $owner->image,
                    'width'    => '300px',
                    'download' => false,
                    'external' => false,
                ])

            </div>

            <div style="width: 300px; margin-top: -54px;">

                <div class="columns">
                    <span class="column is-12 has-text-right">
                        @include('guest.components.link', [
                            'name'   => 'Resume',
                            'href'   => route('guest.resume', $owner),
                            'class'  => 'button is-primary px-1 py-0',
                            'style'  => 'margin-right: 8px;',
                            'target' => '_blank',
                            'title'  => 'Resume',
                        ])
                    </span>
                </div>

                <p class="has-text-centered is-size-5 has-text-weight-bold mb-0">
                    <strong>{!! $owner->name !!}</strong>
                </p>

                @if(!empty($owner->role))
                    <p class="has-text-centered has-text-weight-semibold mb-0">
                        <strong>{!! $owner->role !!}</strong>
                    </p>
                @endif

                @if(!empty($owner->employer))
                    <p class="has-text-centered has-text-weight-medium mb-0">
                        <strong>{!! $owner->employer !!}
                            @if($owner->employment_status_id == 6)
                                (contracting)
                            @endif
                        </strong>
                    </p>
                @elseif($owner->employment_status_id == 7)
                    <p class="has-text-centered mb-0">
                        <strong>self-employed</strong>
                    </p>
                @endif

                @if(in_array($owner->employment_status_id, [2, 3, 4]))
                    <p class="has-text-centered m-1">
                        <span class="has-background-success has-text-weight-semibold has-text-warning p-1 pl-2 pr-2">
                            Open to Work
                        </span>
                    </p>
                @endif

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

                                    <li class="list-item">
                                        @include('guest.components.link', [
                                            'name'  => $resource->plural,
                                            'href'  => $resource->url,
                                            'class' => 'list-item',
                                            'icon'  => $resource->icon,
                                            'style' => [
                                                'color: #4a4a4a',
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
