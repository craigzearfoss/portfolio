@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($owner) ? $owner->name . ' Personal' : 'Personal'),
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard')],
        [ 'name' => 'Personal']
    ],
    'buttons'          => [],
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

    <div class="card m-4">

        <div class="card-body p-4">

            <div class="list is-hoverable">

                <ul class="menu-list" style="max-width: 20em;">

                    @foreach ($personals as $personal)

                        <li>
                            @include('admin.components.link', [
                                'name'  => $personal->plural,
                                'href'  => route('admin.'.$personal->database_name.'.'.$personal->name.'.index',
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

@endsection
