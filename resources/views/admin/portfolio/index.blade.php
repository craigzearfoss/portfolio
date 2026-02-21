@php
    $title    = $pageTitle ?? (!empty($owner) ? $owner->name . ' Portfolio' : 'Portfolio');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="list is-hoverable">

                @include('admin.components.resource-list', [
                    'resourceType' => dbName('portfolio_db'),
                    'resources'    => $portfolios
                ])

            </div>

        </div>
    </div>

@endsection
