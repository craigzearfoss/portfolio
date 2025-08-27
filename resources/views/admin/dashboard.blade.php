@extends('admin.layouts.default', [
    'title' => config('app.name') . 'Admin Dashboard',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard' ],
    ],
    'buttons' => [],
    'errors' => $errors ?? [],
])

@section('content')


    <div class="card p-8 my4">

        <h1 class="p-4">Welcome to {{ config('app.name') }} Admin!</h1>

    </div>

@endsection
