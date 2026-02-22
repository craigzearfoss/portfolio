@php
    use App\Enums\PermissionEntityTypes;

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
    if (canUpdate(PermissionEntityTypes::RESOURCE, $unit, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.personal.unit.edit', $unit)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'unit', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Unit', 'href' => route('admin.personal.unit.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.personal.unit.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

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
                'href'   =>$unit->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row-link', [
                'name'   => !empty($unit->link_name) ? $unit->link_name : 'link',
                'href'   => $unit->link,
                'target' => '_blank'
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

            @include('admin.components.show-row-checkbox', [
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
