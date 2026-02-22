@php
    use App\Enums\EnvTypes;

    $title    = $pagTitle ?? 'About Us';
    $subtitle = false;

    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index')],
        [ 'name' => 'About Us']
    ];

    $buttons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('partials.about-content');

@endsection
