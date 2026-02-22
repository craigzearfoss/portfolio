@php
    $title    = $pageTitle ?? (!empty($owner) ? 'Portfolio for ' . $owner->name : 'Portfolio');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
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

    @if($disclaimerMessage = config('app.demo_disclaimer'))
        @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
    @endif

    <div class="container">

        <ul class="menu-list" style="width: 20rem;">

            @foreach ($portfolios as $i=>$portfolio)

                @if($portfolio->has_owner)

                <li>
                    @include('admin.components.link', [
                        'name'  => $portfolio->plural,
                        'href'  => Route::has('guest.'.$portfolio->database_name.'.'.$portfolio->name.'.index')
                                        ? route('guest.'.$portfolio->database_name.'.'.$portfolio->name.'.index', $owner)
                                        : '',
                        'class' => 'list-item ml-4',
                        'icon'  => $portfolio->icon,
                    ])
                </li>

                @endif

            @endforeach

        </ul>

    </div>

@endsection
