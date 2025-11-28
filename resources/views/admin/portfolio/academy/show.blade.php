@extends('admin.layouts.default', [
    'title' => 'Academy: ' . $academy->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies',       'href' => route('admin.portfolio.academy.index') ],
        [ 'name' => $academy->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'href' => route('admin.portfolio.academy.edit', $academy) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Academy', 'href' => route('admin.portfolio.academy.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'href' => referer('admin.portfolio.academy.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $academy->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $academy->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $academy->slug
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'    => $academy->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link name',
            'value'  => $academy->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($academy->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $academy->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($academy->name, $academy->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => $academy->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $academy->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $academy->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($academy->name . '-thumb', $academy->thumbnail)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo',
            'src'   => $academy->logo,
            'alt'   => 'logo',
            'width' => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($academy->name, $academy->logo)
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'logo small',
            'src'   => $academy->logo_small,
            'alt'   => 'logo small',
            'width' => '100px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($academy->name, $academy->logo_small)
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $academy->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $academy->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $academy->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $academy->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $academy->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($academy->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($academy->updated_at)
        ])

    </div>

@endsection
