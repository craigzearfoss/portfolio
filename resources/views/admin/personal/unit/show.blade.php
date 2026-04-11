@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $unit        = $unit ?? null;

    $title    = $pageTitle ?? 'Unit: ' . $unit->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Units',     'href' => route('admin.personal.unit.index') ],
        [ 'name' => $unit->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($unit, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.unit.edit', $unit)])->render();
    }
    if (canCreate($unit, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Unit', 'href' => route('admin.personal.unit.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.unit.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $unit->id,
                'hide'  => !$isRootAdmin,
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
                'href'   =>$unit->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $unit->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $unit->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $unit->description
            ])

            @include('admin.components.show-row-images', [
                'resource' => $unit,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-checkmark', [
                'name'     => 'sequence',
                'checked' => $unit->sequence,
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
    </div>

@endsection
