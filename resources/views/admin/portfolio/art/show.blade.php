@php
    $buttons = [];
    if (canUpdate($art)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.art.edit', $art) ];
    }
    if (canCreate($art)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Art', 'href' => route('admin.portfolio.art.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.art.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => 'Art: ' . $art->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Art',             'href' => route('admin.portfolio.art.index') ],
        [ 'name' => $art->name ],
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
            'value' => $art->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $art->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($art->name)
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => htmlspecialchars($art->artist)
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $art->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'featured',
            'checked' => $art->featured
        ])

        @include('admin.components.show-row', [
            'name'  => 'summary',
            'value' => htmlspecialchars($art->summary)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $art->year
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $art->image_url,
            'width'    => '300px',
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => nl2br(htmlspecialchars($art->notes))
        ])

        @if(!empty($art->link))
            @include('admin.components.show-row-link', [
                'name'   => $art->link_name,
                'href'   => $art->link,
                'target' => '_blank'
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($art->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $art->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $art->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($art->name), $art->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($art->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($art->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $art->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug(htmlspecialchars($art->name) . '-thumb', $art->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $art->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $art->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $art->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $art->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $art->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($art->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($art->updated_at)
        ])

    </div>

@endsection
