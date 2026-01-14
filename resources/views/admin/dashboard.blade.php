@extends('admin.layouts.default', [
    'title'         => 'Admin Dashboard',
    'breadcrumbs'   => [
        [ 'name' => 'Home', 'href' => route('home') ],
        [ 'name' => 'Admin Dashboard' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin ?? null
])

@section('content')

    <div class="container has-text-centered" style="width: 50em;">

        <h2 class="title p-4">Welcome to {!! config('app.name') !!} Admin!</h2>

    </div>

    @if(isRootAdmin())

        <div class="card p-4">

            <h4 class="title is-size-4 mb-2">Users</h4>
            @include('admin.components.admins-table', ['admins' => $admins])

        </div>

    @endif

@endsection
