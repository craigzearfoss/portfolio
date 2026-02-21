@php
    use App\Enums\EnvTypes;

    // set breadcrumbs
    $title    = $pagTitle ?? 'Contact Us';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Contact Us']
    ];

    $buttons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('partials.contact-content', [ 'envType' => EnvTypes::ADMIN ])

@endsection
