@php /* for url '/admin/' */ @endphp
@extends('guest.layouts.default', [
    'title'         => config('app.name'),
    'breadcrumbs'   => [],
    'buttons'       => [],
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    <div class="has-text-centered mt-4 pt-4" style="max-width: 80em;">

        <div class="card m-4 p-4 has-text-centered">

            <h1 class="title">{!! config('app.name') !!} Admin</h1>

            <a class="is-size-6" href="{!! route('user.login') !!}">
                User Login
            </a>
            |
            <a class="is-size-6" href="{!! route('admin.login') !!}">
                Admin Login
            </a>

        </div>

    </div>

@endsection
