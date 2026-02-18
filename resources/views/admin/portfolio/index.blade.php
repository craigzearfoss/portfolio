@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($owner) ? $owner->name . ' Portfolio' : 'Portfolio'),
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
                        'resourceType' => dbName('portfolio_db'),
                        'resources'    => $portfolios
                    ])

                </div>
            </div>
        </div>

    </div>

@endsection
