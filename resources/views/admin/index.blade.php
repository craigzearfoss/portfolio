@php
    use App\Enums\EnvTypes;

    // set breadcrumbs
    $title    = $pagTitle ?? config('app.name');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard' ],
    ];

    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="has-text-centered mt-4 pt-4" style="max-width: 80em;">

        <div class="card m-4 p-4 has-text-centered">

            <h1 class="title">{!! config('app.name') !!} Admin</h1>

            <a class="is-size-6" href="{!! route('admin.login') !!}">
                User Login
            </a>
            |
            <a class="is-size-6" href="{!! route('admin.login') !!}">
                Admin Login
            </a>

        </div>

    </div>

@endsection
