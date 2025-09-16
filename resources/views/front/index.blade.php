@extends('front.layouts.default', [
    'title'   => config('app.name'),
    'breadcrumbs' => [],
    'buttons' => [],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card column p-4">

        <div class="column has-text-centered">

            <h1 class="title">{{ config('app.name') }}</h1>

            <div class="is-centered">
                <a class="is-size-6" href="{{ route('front.login') }}">
                    User Login
                </a>
                |
                <a class="is-size-6" href="{{ route('front.login') }}">
                    Admin Login
                </a>
            </div>

        </div>

    </div>

@endsection
