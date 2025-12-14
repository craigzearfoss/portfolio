@php
    $buttons = [];
    if (canUpdate($certification)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.certification.edit', $certification) ];
    }
    if (canCreate($certification)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Certification', 'href' => route('admin.portfolio.certification.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.certification.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Certification: ' . $certification->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Certifications',  'href' => route('admin.portfolio.certification.index') ],
        [ 'name' => $certification->name ],
    ],
    'buttons' => $buttons,
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $certification->id
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
            'value' => nl2br(htmlspecialchars($certification->notes))
        ])

        @if(!empty($certification->link))
            @include('admin.components.show-row-link', [
                'name'   => $certification->link_name,
                'href'   => $certification->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($certification->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $certification->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($certification->name), $certification->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($certification->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($certification->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $certification->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($certification->name) . '-thumb', $certification->thumbnail)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo',
            'src'   => $certification->logo,
            'alt'   => 'logo',
            'width' => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($certification->name) . '-logo', $certification->logo)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo small',
            'src'   => $certification->logo_small,
            'alt'   => 'logo small',
            'width' => '100px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($certification->name) . '-logo-sm', $certification->logo_small)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $certification->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $certification->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $certification->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $certification->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $certification->disabled
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

@endsection
