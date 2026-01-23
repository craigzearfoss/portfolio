@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? 'Personal',
    'breadcrumbs'      => [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Users',      'href' => route('guest.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => $title ?? 'Personal' ],
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
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
                        {!! $owner->name !!} Personal
                    </h3>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($resources as $resource)

                            @if(empty($resource->global) && Route::has('guest.admin.personal.'.$resource->name.'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resource->plural,
                                        'href'  => route('guest.personal.'.$resource->name.'.index', $owner),
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
