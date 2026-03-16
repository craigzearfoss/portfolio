@php
    $title    = $pageTitle ?? (!empty($owner) ? 'Portfolio for ' . $owner->name : 'Portfolio');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home',       'href' => route('guest.index') ],
            [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
            [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
            [ 'name' => 'Portfolio' ],
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

    <div class="container">

        <ul class="menu-list" style="width: 20rem;">

            @foreach ($portfolios as $i=>$portfolio)

                @if($portfolio->has_owner)

                <li>
                    @include('admin.components.link', [
                        'name'  => $portfolio->plural,
                        'href'  => Route::has('guest.'.$portfolio->database['name'] . '.' . $portfolio->name . '.index')
                                        ? route('guest.'.$portfolio->database['name'] . '.' . $portfolio->name . '.index', $owner)
                                        : '',
                        'class' => 'list-item ml-4',
                        'style' => 'color: #363636;',
                        'icon'  => $portfolio->icon,
                    ])
                </li>

                @endif

            @endforeach

        </ul>

    </div>

@endsection
