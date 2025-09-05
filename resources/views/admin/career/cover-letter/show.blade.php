@extends('admin.layouts.default', [
    'title' => $coverLetter->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',   'url' => route('admin.career.cover-letter.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',        'url' => route('admin.career.cover-letter.edit', $coverLetter) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Cover Letter', 'url' => route('admin.career.cover-letter.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',           'url' => route('admin.career.cover-letter.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $coverLetter->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'slug',
            'value' => $coverLetter->slug
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($coverLetter->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'content',
            'value' => $coverLetter->content
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'url'    => $coverLetter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $coverLetter->link_name
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'alt link',
            'url'    => $coverLetter->alt_link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'alt link name',
            'url'    => $coverLetter->alt_link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $coverLetter->description
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image',
            'value' => $coverLetter->image
        ])

        @include('admin.components.show-row-image', [
            'name'  => 'image_credit',
            'value' => $coverLetter->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $coverLetter->image_source
        ])

        @include('admin.components.show-row', [
            'name'  => 'thumbnail',
            'value' => $coverLetter->thumbnail
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'primary',
            'checked' => $coverLetter->primary
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $coverLetter->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $coverLetter->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $coverLetter->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $coverLetter->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $coverLetter->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $coverLetter->admin['username'] ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($coverLetter->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($coverLetter->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($coverLetter->deleted_at)
        ])

    </div>

@endsection
