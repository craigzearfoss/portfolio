@php
    use App\Enums\EnvTypes;

    $title    = $pageTitle ?? 'Contact Us';
    $subtitle = false;

    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home', 'href' => route('guest.index')],
            [ 'name' => 'Contact Us']
          ];

    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('partials.contact-content', [ 'envType' => EnvTypes::GUEST ])

@endsection
