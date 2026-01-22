@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Portfolios',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => $title ?? 'Portfolio' ],
    ],
    'buttons'          => [],
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

    <div class="card m-4">

        <div class="card-body p-4">

            <div class="container">
                <div class="content">

                    <h3 class="title">
                        {!! $owner->name !!} Portfolio
                    </h3>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($resources as $resource)

                            @if(empty($resource->global) && Route::has('guest.admin.portfolio.'.$resource->name.'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resource->plural,
                                        'href'  => route('guest.portfolio.'.$resource->name.'.index', $owner),
                                        'class' => 'pt-1 pb-1',
                                    ])
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>
            </div>

        </div>

    </div>

@endsection
