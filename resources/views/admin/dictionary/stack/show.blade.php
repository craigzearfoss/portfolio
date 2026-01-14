@php
    $buttons = [];
    if (canUpdate($stack, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.dictionary.stack.edit', $stack) ];
    }
    if (canCreate($stack, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.dictionary.stack.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.dictionary.stack.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $stack->name . ' (stack)',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Stacks',          'href' => route('admin.dictionary.stack.index') ],
        [ 'name' => $stack->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $stack->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $stack->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $stack->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $stack->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $stack->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $stack->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $stack->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $stack->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $stack->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $stack->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $stack->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($stack->link_name) ? $stack->link_name : 'link',
            'href'   => $stack->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $stack->description
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $stack->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($stack->name, $stack->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $stack->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $stack->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $stack->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($stack->name . '-thumb', $stack->thumbnail)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $stack,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($stack->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($stack->updated_at)
        ])

    </div>

@endsection
