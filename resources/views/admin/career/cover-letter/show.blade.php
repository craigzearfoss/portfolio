@extends('admin.layouts.default', [
    'title' => $coverLetter->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Cover Letters',   'href' => route('admin.career.cover-letter.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',        'url' => route('admin.career.cover-letter.edit', $coverLetter) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Cover Letter', 'url' => route('admin.career.cover-letter.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',           'url' => referer('admin.career.cover-letter.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $coverLetter->id
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
            'name'   => 'cover_letter_url',
            'url'    => $coverLetter->cover_letter_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $coverLetter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $coverLetter->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($coverLetter->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $coverLetter->image,
            'alt'      => $coverLetter->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($coverLetter->name, $coverLetter->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_credit',
            'value' => $coverLetter->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $coverLetter->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $coverLetter->thumbnail,
            'alt'      => $coverLetter->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($coverLetter->name, $coverLetter->thumbnail)
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

    </div>

@endsection
