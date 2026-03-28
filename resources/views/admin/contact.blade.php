@php
    use App\Enums\EnvTypes;

    $title    = $pageTitle ?? 'Contact Us';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Contact Us']
    ];

    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @if(!$success = session('success'))

        @include('partials.contact-content', [
            'envType'    => EnvTypes::ADMIN,
            'from_admin' => true
        ])

    @endif

@endsection
