@php
    $title    = $pageTitle ?? 'Candidates';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Candidates' ]
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if($disclaimerMessage = config('app.demo_disclaimer'))
        @include('guest.components.disclaimer', [ 'value' => $disclaimerMessage ])
    @endif

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('guest.components.candidates-table', ['candidates' => $candidates])

        </div>
    </div>

@endsection
