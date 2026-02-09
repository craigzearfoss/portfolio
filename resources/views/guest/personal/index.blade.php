@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => $owner->name ?? 'Personal' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? (!empty($owner) ? 'Personal for ' . $owner->name : 'Personal'),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card m-0">

        <div class="card-body p-4">

            <div class="list is-hoverable">

                <ul class="menu-list" style="max-width: 20em;">

                    @foreach ($personals as $personal)

                        <?php /* @TODO: This is a hack to filter out level 2 resources. Need to find the proper way to do this */ ?>
                        @if(!in_array($personal->name, ['recipe-ingredient', 'recipe-step']))

                            <li>
                                @include('admin.components.link', [
                                    'name'  => $personal->plural,
                                    'href'  => Route::has('guest.personal.'.$personal->name.'.index')
                                                    ? route('guest.personal.'.$personal->name.'.index', $owner)
                                                    : '',
                                    'class' => 'list-item',
                                ])
                            </li>

                        @endif

                    @endforeach

                </ul>

            </div>

        </div>

</div>

@endsection
