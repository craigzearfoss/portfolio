@php
    $buttons = [];
    if (canUpdate($unit)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.personal.unit.edit', $unit) ];
    }
    if (canCreate($unit)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Unit', 'href' => route('admin.personal.unit.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.personal.unit.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Unit: ' . $unit->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Units',           'href' => route('admin.personal.unit.index') ],
        [ 'name' => $unit->name ],
    ],
    'buttons' => $buttons,
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
            'href'   => $unit->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'value'  => $unit->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($unit->description ?? '')
        ])

        @include('admin.components.show-row-images', [
            'resource' => $unit,
            'download' => true,
            'external' => true,
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
