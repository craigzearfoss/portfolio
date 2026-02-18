@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($owner) ? $owner->name . ' System' : 'System'),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div style="display: flex;">

        <div class="card m-4">
            <div class="card-body p-4">
                <div class="list is-hoverable">

                    @include('admin.components.resource-list', [
                        'resourceType' => dbName('system_db'),
                        'resources'    => $systems
                    ])

                </div>
            </div>
        </div>

    </div>

@endsection
