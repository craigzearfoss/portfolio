@extends('admin.layouts.empty', [
    'title'       => 'Admin',
    'breadcrumbs' => [],
    'buttons'     => [],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="columns has-text-centered mt-4 pt-4">

        <div class="card column is-6 m-4 p-4  has-text-centered">

            <h1 class="title">{{ config('app.name') }} Admin</h1>

            <a class="is-size-6" href="{{ route('admin.login') }}">
                Admin Login
            </a>
            |
            <a class="is-size-6" href="{{ route('admin.login') }}">
                User Login
            </a>

        </div>

    </div>

@endsection
