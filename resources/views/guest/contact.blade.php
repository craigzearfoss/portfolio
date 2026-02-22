@php
    use App\Enums\EnvTypes;

    $title    = $pageTitle ?? 'Contact Us';
    $subtitle = false;

    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index')],
        [ 'name' => 'Contact Us']
    ];

    $buttons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('partials.contact-content', [ 'envType' => EnvTypes::GUEST ])

@endsection
