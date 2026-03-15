@php
    use App\Enums\EnvTypes;

    $title    = $pagTitle ?? 'About Us';
    $subtitle = false;

    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home', 'href' => route('guest.index')],
            [ 'name' => 'About Us']
          ];

    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('partials.about-content');

@endsection
