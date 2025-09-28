@extends('admin.layouts.default', [
    'title' => $unit->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',       'href' => route('admin.personal.index') ],
        [ 'name' => 'Units',           'href' => route('admin.personal.unit.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.personal.unit.edit', $unit) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Unit',  'url' => route('admin.personal.unit.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => referer('admin.personal.unit.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $unit->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $unit->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $unit->abbreviation
        ])

        @include('admin.components.show-row', [
            'name'  => 'system',
            'value' => $unit->system
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'label'  => $unit->link_name,
            'url'    => $unit->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($unit->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $unit->image,
            'alt'      => $unit->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($unit->name, $unit->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $unit->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $unit->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $unit->thumbnail,
            'alt'      => $unit->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($unit->name, $unit->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $unit->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $unit->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $unit->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $unit->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $unit->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($unit->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($unit->updated_at)
        ])

    </div>

@endsection
