@extends('admin.layouts.default', [
    'title' => $jobBoardBoard->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Job Boards',      'url' => route('admin.career.job-board.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',     'url' => route('admin.career.job-board.edit', $jobBoardBoard) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Job Board', 'url' => route('admin.career.job-board.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',        'url' => route('admin.career.job-board.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $jobBoardBoard->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $jobBoardBoard->slug
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $jobBoardBoard->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $jobBoardBoard->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $jobBoardBoard->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $jobBoard->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image_credit',
            'value' => $jobBoard->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $jobBoard->image_source
        ])

        @include('admin.components.show-row', [
            'name'  => 'thumbnail',
            'value' => $jobBoard->thumbnail
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $jobBoardBoard->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $jobBoardBoard->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $jobBoardBoard->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $jobBoardBoard->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $jobBoardBoard->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($jobBoardBoard->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($jobBoardBoard->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($jobBoardBoard->deleted_at)
        ])

    </div>

@endsection
