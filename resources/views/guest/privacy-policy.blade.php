@php
    use App\Enums\EnvTypes;

    $title    = $pageTitle ?? 'Privacy Policy';
    $subtitle = false;

    $breadcrumbs = $publicAdminCount < 2
        ? []
        : [
            [ 'name' => 'Home', 'href' => route('guest.index')],
            [ 'name' => 'Privacy Policy']
          ];

    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('partials.privacy-policy-content');

@endsection
