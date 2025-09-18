@extends('admin.layouts.default', [
    'title' => $resume->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Resumes',         'url' => route('admin.career.resume.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'url' => route('admin.career.resume.edit', $resume) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'url' => route('admin.career.resume.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => referer('admin.career.resume.index') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $resume->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $resume->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($resume->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'content',
            'value' => $resume->content
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $resume->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $resume->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $resume->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'src'   => $resume->image,
            'alt'   => $resume->name,
            'width' => '300px',
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image credit',
            'value' => $resume->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => $resume->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'thumbnail',
            'src'   => $resume->thumbnail,
            'alt'   => $resume->name,
            'width' => '40px',
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $resume->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $resume->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $resume->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $resume->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $resume->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($resume->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($resume->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($resume->deleted_at)
        ])

    </div>

@endsection
