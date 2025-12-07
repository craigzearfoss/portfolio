@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Resumes',          'href' => route('admin.career.resume.index', ['application_id' => $application->id]) ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ]
        ];
    }
@endphp
@extends('admin.layouts.default', [
    'title' => $title ?? 'Resume: ' . $resume->name . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ],
        [ 'name' => $resume->name ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',  'href' => route('admin.career.resume.edit', $resume) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Resume', 'href' => route('admin.career.resume.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'href' => referer('admin.career.resume.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $resume->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $resume->owner->username ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($resume->name)
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'primary',
            'checked' => $resume->primary
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
            'name'   => 'doc url',
            'label'  => $resume->doc_url,
            'href'   => $resume->doc_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'pdf url',
            'label'  => $resume->pdf_url,
            'href'   => $resume->pdf_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $resume->notes
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'href' => $resume->link,
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $resume->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($resume->description ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [ 'value' => $art->disclaimer ?? '' ])
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'image',
            'src'      => $resume->image,
            'alt'      => 'image',
            'width'    => '300px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($resume->name, $resume->image)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image credit',
            'value' => htmlspecialchars($resume->image_credit)
        ])

        @include('admin.components.show-row', [
            'name'  => 'image source',
            'value' => htmlspecialchars($resume->image_source)
        ])

        @include('admin.components.show-row-image', [
            'name'     => 'thumbnail',
            'src'      => $resume->thumbnail,
            'alt'      => 'thumbnail',
            'width'    => '40px',
            'download' => true,
            'external' => true,
            'filename' => getFileSlug($resume->name . '-thumb', $resume->thumbnail)
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


        @include('admin.career.resume.application.panel', [
            'applications' => $resume->applications ?? [],
            'links' => []
        ])

    </div>

@endsection
