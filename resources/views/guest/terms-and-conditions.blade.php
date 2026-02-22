@php
    use App\Enums\EnvTypes;

    $title    = $pageTitle ?? 'Terms & Conditions';
    $subtitle = false;

    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index')],
        [ 'name' => 'Terms & Conditions']
    ];

    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    @include('partials.terms-and-conditions-content');

@endsection
