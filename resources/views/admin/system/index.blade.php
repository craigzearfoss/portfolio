@php
    $title = $pageTitle ?? (!empty($owner) ? $owner->name . ' System' : 'System');

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System' ],
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
                    'resourceType' => dbName('system_db'),
                    'resources'    => $systems
                ])

            </div>

        </div>
    </div>

@endsection
