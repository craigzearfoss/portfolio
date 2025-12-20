@php
    $buttons = [];
    if (canUpdate($server, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.dictionary.server.edit', $server) ];
    }
    if (canCreate($server, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.dictionary.server.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.dictionary.server.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $server->name . ' (server)',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Servers',         'href' => route('admin.dictionary.server.index') ],
        [ 'name' => $server->name ],
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
            'value' => $server->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'full name',
            'value' => $server->full_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $server->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $server->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $server->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'definition',
            'value' => $server->definition
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $server->open_source
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $server->proprietary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'compiled',
            'checked' => $server->compiled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $server->owner
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $server->wikipedia,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => $server->link_name ?? 'link',
            'href'   => $server->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($server->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $server->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($server->name, $server->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $server->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $server->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $server->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($server->name . '-thumb', $server->thumbnail)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $server,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($server->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($server->updated_at)
        ])

    </div>

@endsection
