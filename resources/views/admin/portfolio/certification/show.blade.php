@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $certification = $certification ?? null;

    $title    = $pageTitle ?? 'Certification: ' . $certification->name;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',               'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',          'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',     'href' => route('admin.portfolio.certification.index') ],
        [ 'name' => $certification->name ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($certification, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.certification.edit', $certification)])->render();
    }
    if (canCreate($certification, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Certification', 'href' => route('admin.portfolio.certification.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.certification.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $certification->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $certification->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $certification->slug
            ])

            @include('admin.components.show-row', [
                'name'  => 'abbreviation',
                'value' => $certification->abbreviation
            ])

            @include('admin.components.show-row', [
                'name'  => 'type',
                'value' => $certification->certificationType->name ?? ''
            ])

            @include('admin.components.show-row', [
                'name'  => 'organization',
                'value' => $certification->organization
            ])

            @include('admin.components.show-row', [
                'name'  => 'notes',
                'value' => $certification->notes
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $certification->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $certification->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $certification->description
            ])

            @include('admin.components.show-row-images', [
                'resource' => $certification,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $certification,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($certification->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($certification->updated_at)
            ])

        </div>
    </div>

@endsection
