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
    'title'            => $pageTitle ?? 'System',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div style="display: flex;">

        <div class="card m-4">
            <div class="card-body p-4">
                <div class="list is-hoverable">
                    <ul class="menu-list" style="max-width: 20em;">

                        @foreach ($systems as $system)

                            <li>
                                @include('admin.components.link', [
                                    'name'  => $system->plural,
                                    'href'  => route('admin.system.'.$system->name.'.index'),
                                    'class' => 'list-item',
                                ])
                            </li>

                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection
