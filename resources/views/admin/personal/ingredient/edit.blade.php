@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $ingredient  = $ingredient ?? null;

    $title    = 'Edit ' . getResourcePageTitle($ingredient);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                   'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                        'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',                               'href' => route('admin.personal.index') ],
        [ 'name' => 'Ingredients',                            'href' => route('admin.personal.ingredient.index') ],
        [ 'name' => getResourcePageTitle($ingredient, false), 'href' => route('admin.personal.ingredient.show', $ingredient) ],
        [ 'name' => 'Edit' ]
    ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.personal.ingredient.index') ])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.personal.ingredient.update', array_merge([$ingredient], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.personal.ingredient.index')
            ])

            @if ($isRootAdmin)
                @include('admin.components.favorites-box-form-input', [
                    'name'  => 'favorite_count',
                    'label' => 'favorites',
                    'value' => old('favorite_count') ?? $ingredient->favorite_count,
                ])
            @endif

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $ingredient->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'full_name',
                'label'     => 'full name',
                'value'     => old('full_name') ?? $ingredient->full_name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $ingredient->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $ingredient->link,
                'name' => old('link_name') ?? $ingredient->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $ingredient->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.show-row-images', [
                'resource' => $ingredient,
                'upload'   => false,
                'download' => true,
                'external' => true,
                'editPage' => true,
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $ingredient->is_public,
                'is_readonly' => old('is_readonly') ?? $ingredient->is_readonly,
                'is_root'     => old('is_root')     ?? $ingredient->root,
                'is_disabled' => old('is_disabled') ?? $ingredient->is_disabled,
                'is_demo'     => old('is_demo')     ?? $ingredient->is_demo,
                'sequence'    => old('sequence')    ?? $ingredient->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.personal.ingredient.index')
            ])

        </form>

    </div>

@endsection
