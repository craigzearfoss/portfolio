@extends('admin.layouts.default', [
    'title' => $video->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Videos',          'url' => route('admin.portfolio.video.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'url' => route('admin.portfolio.video.edit', $video) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Video', 'url' => route('admin.portfolio.video.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => route('admin.portfolio.video.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $video->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $video->slug
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'professional',
            'checked' => $video->professional
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'personal',
            'checked' => $video->personal
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($video->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'year',
            'value' => $video->year
        ])

        @include('admin.components.show-row', [
            'name'  => 'company',
            'value' => $video->company
        ])

        @include('admin.components.show-row', [
            'name'  => 'credit',
            'value' => $video->credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => $video->location
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $video->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $video->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $video->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'value' => $video->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $video->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $video->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'read-only',
            'checked' => $video->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $video->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $video->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'admin',
            'value' => $video->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($video->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($video->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($video->deleted_at)
        ])

    </div>

@endsection
