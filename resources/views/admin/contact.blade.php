@php
    use App\Enums\EnvTypes;
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Contact Us',
    'subtitle'         => false,
    'breadcrumbs'      => [
        [ 'name' => 'Home', 'href' => route('guest.index')],
        [ 'name' => 'Contact Us']
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

    @include('partials.contact-content', [ 'envType' => EnvTypes::ADMIN ])

@endsection
