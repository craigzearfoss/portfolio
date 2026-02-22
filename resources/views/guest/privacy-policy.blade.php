@php
    use App\Enums\EnvTypes;

    $title    = $pageTitle ?? 'Privacy Policy';
    $subtitle = false;

    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index')],
        [ 'name' => 'Privacy Policy']
    ];

    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('partials.privacy-policy-content');

@endsection
