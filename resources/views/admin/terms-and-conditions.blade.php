@php
    use App\Enums\EnvTypes;

    // set breadcrumbs
    $title    = $pagTitle ?? 'Terms & Conditions';
    $subtitle = false;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Terms & Conditions']
    ];

    $buttons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('partials.terms-and-conditions-content');

@endsection
