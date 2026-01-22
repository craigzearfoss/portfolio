@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin Dashboard',
    'breadcrumbs'      => [
        [ 'name' => 'Home', 'href' => route('home') ],
        [ 'name' => 'Admin Dashboard' ],
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

    <div class="container has-text-centered" style="width: 50em;">

        <h2 class="title p-2 mb-2">Welcome to {!! config('app.name') !!} Admin!</h2>

    </div>

    @if($admin->root)

        <div class="card p-4">

            <h4 class="title is-size-4 mb-2">Admins</h4>
            @include('admin.components.admins-table', ['owners' => $owners])

        </div>

    @endif

@endsection
