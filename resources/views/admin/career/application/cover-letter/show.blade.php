@extends('admin.layouts.default', [
    'title' => 'Cover Letter: ' . $application->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',           'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',     'href' => route('admin.career.application.index') ],
        [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
        [ 'name' => 'Cover Letter' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.application.cover-letter.edit', $application) ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.career.application.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card form-container p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $application->cover_letter->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $application->cover_letter->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'    => 'application',
            'value'   => view('admin.components.link', [
                'name' => $application->name ?? '',
                'href' => route('admin.career.application.show', $application->cover_letter->application),
            ]),
            'message' => $message ?? '',
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'date',
            'value' => longDate($application->cover_letter->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'content',
            'value' => $application->cover_letter->content
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'cover letter url',
            'href'   => $application->cover_letter->cover_letter_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $application->cover_letter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $application->cover_letter->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($application->cover_letter->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $application->cover_letter->image,
            'alt'      => $application->cover_letter->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->cover_letter->name, $application->cover_letter->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_credit',
            'value' => $application->cover_letter->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $application->cover_letter->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $application->cover_letter->thumbnail,
            'alt'      => $application->cover_letter->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->cover_letter->name, $application->cover_letter->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $application->cover_letter->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $application->cover_letter->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $application->cover_letter->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $application->cover_letter->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $application->cover_letter->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($application->cover_letter->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($application->cover_letter->updated_at)
        ])

    </div>

@endsection
