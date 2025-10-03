@extends('admin.layouts.default', [
    'title' => $resume->name,
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ],
        [ 'name' => 'Show' ],
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

    <div class="card p-4">

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $resume->owner['username'] ?? ''
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $resume->id
        ])

        @php
            $application = !empty($resume->application_id)
                ? \App\Models\Career\Application::find($resume->application_id)
                : null;
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'application_id',
            'value' => !empty($application)
                ? ($application->company['name'] . ' - ' . $application->role . ' [' . $application->apply_date . ']')
                : ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $resume->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($resume->date)
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'primary',
            'checked' => $resume->primary
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

        @include('admin.components.show-row-link', [
            'name'  => 'link',
            'href'   => $resume->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $resume->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'link name',
            'value' => $resume->link_name
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($resume->description ?? '')
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


        @include('admin.components.resume.applications-panel', [
            'applications' => $resume->applications ?? [],
            'links' => []
        ])

    </div>

@endsection
