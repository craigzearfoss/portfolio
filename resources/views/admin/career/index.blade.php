@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($owner) ? $owner->name . ' Career' : 'Career'),
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

                        @foreach ($careers as $career)

                            <li>
                                @include('admin.components.link', [
                                    'name'  => $career->plural,
                                    'href'  => route('admin.'.$career->database_name.'.'.$career->name.'.index',
                                                     $admin->root && !empty($owner) ? [ 'owner_id' => $owner ] : []
                                               ),
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
