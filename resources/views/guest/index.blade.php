@extends('guest.layouts.default', [
    'title'   => config('app.name'),
    'breadcrumbs' => [],
    'buttons' => [],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card column p-4">

        <div class="column has-text-centered">

            <h1 class="title">{{ config('app.name') }}</h1>

            <div class="has-text-centered">
                <a class="is-size-6" href="{{ route('guest.login') }}">
                    User Login
                </a>
                |
                <a class="is-size-6" href="{{ route('admin.login') }}">
                    Admin Login
                </a>
            </div>

        </div>

    </div>

@endsection
