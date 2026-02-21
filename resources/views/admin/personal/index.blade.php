@php
    $title    = $pageTitle ?? (!empty($owner) ? $owner->name . ' Personal' : 'Personal');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('admin.layouts.default', [
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
])

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="list is-hoverable">

                @include('admin.components.resource-list', [
                    'resourceType' => dbName('personal_db'),
                    'resources'    => $personals
                ])

            </div>

        </div>
    </div>

@endsection
