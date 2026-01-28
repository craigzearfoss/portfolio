@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Resumes',          'href' => route('admin.career.resume.index', ['application_id' => $application->id]) ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ]
        ];
    }

    $buttons = [];
    if (canUpdate($resume, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.resume.edit', $resume)])->render();
    }
    if (canCreate('resume', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Resume', 'href' => route('admin.career.resume.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.resume.index')])->render();
@endphp

@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Resume: ' . $resume->name . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index') ],
        [ 'name' => 'Resumes',         'href' => route('admin.career.resume.index') ],
        [ 'name' => $resume->name ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $resume->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $resume->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $resume->name
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
            'label'  => !empty($resume->doc_url) ? $resume->doc_url : '.doc url',
            'href'   => $resume->doc_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'pdf url',
            'label'  => !empty ($resume->pdf_url) ? $resume->pdf_url : '.pdf url',
            'href'   => $resume->pdf_url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $resume->notes
        ])

        @include('admin.components.show-row', [
            'name'  => 'file type',
            'value' => $resume->file_type
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($resume->link_name) ? $resume->link_name : 'link',
            'href'   => $resume->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $resume->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $resume->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $resume,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $resume,
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
