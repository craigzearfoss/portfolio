@extends('admin.layouts.default', [
    'title' => config('app.name') . ' Admin Dashboard',
    'breadcrumbs' => [
        [ 'name' => 'Home', 'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard' ],
    ],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-8 my-4 container" style="width: 50em;">

        <h1 class="p-4">Welcome to {{ config('app.name') }} Admin!</h1>

    </div>

@endsection
