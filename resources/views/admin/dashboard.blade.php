@php
    use App\Enums\EnvTypes;

    // set breadcrumbs
    $title    = $pagTitle ?? 'Admin Dashboard';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard' ]
    ];

    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="container has-text-centered" style="width: 50em;">

        <h2 class="title p-2 mb-2">Welcome to {!! config('app.name') !!} Admin!</h2>

    </div>

    @if($admin->root)

        <div class="floating-div-container">
            <div class="show-container card floating-div">

                <h4 class="title is-size-4 mb-2">Admins</h4>
                @include('admin.components.admins-table', ['admins' => $owners])

            </div>
        </div>

    @endif

@endsection
