@php
    $buttons = [];
    if (canUpdate($photo, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.photography.edit', $photo) ];
    }
    if (canCreate($photo, currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Photo', 'href' => route('admin.portfolio.photography.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.portfolio.photography.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Photography: ' . $photo->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Photo',           'href' => route('admin.portfolio.photography.index') ],
        [ 'name' => $photo->name ],
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
            'value' => $photo->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $photo->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($photo->name ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => htmlspecialchars($photo->artist ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $photo->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $photo->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => $photo->summary ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $photo->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $photo->notes ?? ''
        ])

        @include('admin.components.show-row-link', [
            'name'   => htmlspecialchars($photo->link_name ?? 'link'),
            'href'   => htmlspecialchars($photo->link ?? ''),
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $photo->description ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => htmlspecialchars($photo->disclaimer ?? '')
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $photo,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $photo,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($photo->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($photo->updated_at)
        ])

    </div>

@endsection
