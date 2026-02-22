@php
    $title     = $pageTitle ?? 'Add New Ingredient';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Ingredients',     'href' => route('admin.personal.ingredient.index') ],
        [ 'name' => 'Add' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.personal.ingredient.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.personal.ingredient.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.personal.ingredient.index')
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'full_name',
                'label'     => 'full name',
                'value'     => old('full_name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? 0,
                'readonly'    => old('readonly') ?? 0,
                'root'        => old('root')     ?? 0,
                'disabled'    => old('disabled') ?? 0,
                'demo'        => old('demo')     ?? 0,
                'sequence'    => old('sequence') ?? 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Ingredient',
                'cancel_url' => referer('admin.personal.ingredient.index')
            ])

        </form>

    </div>

@endsection
