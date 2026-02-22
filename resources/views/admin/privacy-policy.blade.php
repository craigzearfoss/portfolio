@php
    use App\Enums\EnvTypes;

    // set breadcrumbs
    $title    = $pagTitle ?? 'Privacy Policy';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Privacy Policy']
    ];

    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('partials.privacy-policy-content');

@endsection
