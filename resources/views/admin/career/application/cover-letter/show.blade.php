@extends('admin.layouts.default', [
    'title' => 'Cover Letter: ' . $application->name,
    'breadcrumbs' => [
        [ 'name' => 'Home',             'href' => route('system.index') ],
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
    'errorMessages' => $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card form-container p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $application->coverLetter->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $application->coverLetter->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'    => 'application',
            'value'   => view('admin.components.link', [
                'name' => $application->name ?? '',
                'href' => route('admin.career.application.show', $application->coverLetter->application),
            ]),
            'message' => $message ?? '',
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'date',
            'value' => longDate($application->coverLetter->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'content',
            'value' => $application->coverLetter->content
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'cover letter url',
            'href'   => $application->coverLetter->cover_letter_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $application->coverLetter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $application->coverLetter->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($application->coverLetter->description ?? '')
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $application->coverLetter->image,
            'alt'      => $application->coverLetter->name,
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->coverLetter->name, $application->coverLetter->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_credit',
            'value' => $application->coverLetter->image_credit
        ])

        @include('admin.components.show-row', [
            'name'  => 'image_source',
            'value' => $application->coverLetter->image_source
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $application->coverLetter->thumbnail,
            'alt'      => $application->coverLetter->name,
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($application->coverLetter->name, $application->coverLetter->thumbnail)
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $application->coverLetter->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $application->coverLetter->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $application->coverLetter->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $application->coverLetter->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $application->coverLetter->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($application->coverLetter->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($application->coverLetter->updated_at)
        ])

    </div>

@endsection
