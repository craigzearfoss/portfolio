@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? ($isRootAdmin && !empty($owner) ? ($owner->name . ' ' ?? '') : '') . 'Career Resources';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.system.index') ],
        [ 'name' => 'Career' . ($isRootAdmin && !empty($owner) ? ' (' . $owner->name . ')' : '') ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="list is-hoverable">

                @include('admin.components.resource-list', [
                    'resourceType' => dbName('career_db'),
                    'resources'    => $careers,
                    'owner_id'     => $isRootAdmin ? request()->input('owner_id') : null,
                ])

            </div>

        </div>
    </div>

@endsection
