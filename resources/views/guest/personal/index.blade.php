@php
    $title    = $pageTitle ?? (!empty($owner) ? 'Personal for ' . $owner->name : 'Personal');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Personal' ],
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

            @foreach($personals as $personal)

                @if($personal->has_owner && !in_array($personal->name, [ 'ingredient', 'recipe-ingredient', 'recipe-step' ]))

                <li>
                    @include('admin.components.link', [
                        'name'  => $personal->plural,
                        'href'  => Route::has('guest.'.$personal->database_name.'.'.$personal->name.'.index')
                                        ? route('guest.'.$personal->database_name.'.'.$personal->name.'.index', $owner)
                                        : '',
                        'class' => 'list-item ml-4',
                        'icon'  => $personal->icon,
                    ])
                </li>

                @endif

            @endforeach

        </ul>

    </div>

@endsection
