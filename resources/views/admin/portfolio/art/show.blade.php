@extends('admin.layouts.default', [
    'title' => 'Art: ' . $art->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Art',             'href' => route('admin.portfolio.art.index') ],
        [ 'name' => $art->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.portfolio.art.edit', $art) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Art',   'href' => route('admin.portfolio.art.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.portfolio.art.index') ],
    ],
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
                'value' => $art->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $art->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'artist',
            'value' => $art->artist
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
            'value' => $art->summary
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
            'value' => $art->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $art->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link name',
            'value'  => $art->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($art->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $art->image,
            'alt'      => $art->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($art->name, $art->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_credit',
            'value' => $art->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $art->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $art->thumbnail,
            'alt'   => $art->name,
            'width'     => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($art->name, $art->thumbnail)
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
