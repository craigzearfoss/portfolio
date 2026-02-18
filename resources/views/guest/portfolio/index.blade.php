@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? (!empty($owner) ? 'Portfolio for ' . $owner->name : 'Portfolio'),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div style="display: flex;">

        <div class="card m-0">
            <div class="card-body p-4">
                <div class="list is-hoverable">
                    <ul class="menu-list" style="max-width: 20em;">

                        @foreach ($portfolios as $portfolio)

                            <li>
                                @include('admin.components.link', [
                                    'name'  => $portfolio->plural,
                                    'href'  => Route::has('guest.portfolio.'.$portfolio->name.'.index')
                                                    ? route('guest.portfolio.'.$portfolio->name.'.index', $owner)
                                                    : '',
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
