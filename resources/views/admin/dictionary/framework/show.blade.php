@php
    $buttons = [];
    if (canUpdate($framework, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.dictionary.framework.edit', $framework) ];
    }
    if (canCreate($framework, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.dictionary.framework.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.dictionary.framework.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $framework->name . ' (framework)',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Frameworks',      'href' => route('admin.dictionary.framework.index') ],
        [ 'name' => $framework->name ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $framework->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => htmlspecialchars($framework->full_name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($framework->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $framework->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($framework->abbreviation ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $framework->definition ?? ''
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $framework->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $framework->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $framework->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => htmlspecialchars($framework->owner ?? '')
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $framework->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($framework->link_name ?? 'link'),
            'href'   => htmlspecialchars($framework->link ?? ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $framework->description ?? ''
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $framework->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($framework->name, $framework->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $framework->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $framework->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $framework->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($framework->name . '-thumb', $framework->thumbnail)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $framework,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($framework->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($framework->updated_at)
        ])

    </div>

@endsection
