@extends('admin.layouts.default', [
    'title' => $academy->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies',       'url' => route('admin.portfolio.academy.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',   'url' => route('admin.portfolio.academy.edit', $academy) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Academy', 'url' => route('admin.portfolio.academy.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',      'url' => Request::header('referer') ?? route('admin.portfolio.academy.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

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
            'url'    => $academy->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $academy->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $academy->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $academy->image,
            'alt'   => $academy->name,
            'width' => '300px',
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
            'name'  => 'thumbnail',
            'src'   => $academy->thumbnail,
            'alt'   => $academy->name,
            'width' => '40px',
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

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($academy->deleted_at)
        ])

    </div>

@endsection
