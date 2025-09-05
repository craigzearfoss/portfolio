@extends('admin.layouts.empty', [
    'title'   => 'Admin',
    'errors'  => $errors ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card column is-5 p-4">

        <div class="column has-text-centered">

            <h1 class="title">{{ config('app.name') }} Admin</h1>

                <a class="btn btn-sm" href="{{ route('admin.login') }}">
                    Admin Login
                </a>
        </div>

    </div>

@endsection
