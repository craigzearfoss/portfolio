@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Portfolios',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => $title ?? 'Portfolio' ],
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="card m-4">

        <div class="card-body p-4">

            <div class="container">
                <div class="content">

                    <h3 class="title">
                        {!! $admin->name !!} Portfolio
                    </h3>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($resources as $resource)

                            @if(empty($resource->global) && Route::has('guest.admin.portfolio.'.$resource->name.'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resource->plural,
                                        'href'  => route('guest.portfolio.'.$resource->name.'.index', $admin),
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
