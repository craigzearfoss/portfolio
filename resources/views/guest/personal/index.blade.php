@php
    $title    = $pageTitle ?? (!empty($owner) ? 'Personal for ' . $owner->name : 'Personal');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
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

    @if($owner->is_demo)
        @if($disclaimerMessage = config('app.demo_disclaimer'))
            @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
        @endif
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="list is-hoverable">

                @include('guest.components.resource-list', [
                    'resourceType' => dbName('personal_db'),
                    'resources'    => $personals
                ])

            </div>

        </div>
    </div>

@endsection
