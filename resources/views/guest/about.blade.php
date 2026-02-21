@php
    use App\Enums\EnvTypes
@endphp
@extends('guest.layouts.default', [
    'title'            => $pagTitle ?? 'About Us',
    'subtitle'         => false,
    'breadcrumbs'      => [
        [ 'name' => 'Home', 'href' => route('guest.index')],
        [ 'name' => 'About Us']
    ],
    'buttons'          => [],
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('partials.about-content');

@endsection
