@php
    use App\Enums\EnvTypes;

    $title    = $pageTitle ?? 'Contact Us';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index')],
        [ 'name' => 'Contact Us']
    ];

    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @if(!$success = session('success'))

        @include('partials.contact-content', [
            'envType'       => EnvTypes::GUEST,
            'from_admin' => false
        ])

    @endif

@endsection
