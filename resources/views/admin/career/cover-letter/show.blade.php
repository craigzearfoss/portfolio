@php
    $buttons = [];
    if (canUpdate($coverLetter, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.cover-letter.edit', $coverLetter) ];
    }
    if (canCreate($coverLetter, getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Cover Letter', 'href' => route('admin.career.cover-letter.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.cover-letter.index') ];
@endphp
@extends('admin.layouts.default', [
    'title'         => $pageTitle ?? 'Cover Letter: ' . $coverLetter->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',             'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',           'href' => route('admin.career.index') ],
        [ 'name' => $coverLetter->name, 'href' => route('admin.career.application.show', $coverLetter->application)],
        [ 'name' => 'Cover Letters' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $coverLetter->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $coverLetter->owner->username
            ])
        @endif

        @include('admin.components.show-row', [
            'name'    => 'application',
            'value'   => view('admin.components.link', [
                             'name' => $coverLetter->name,
                             'href' => route('admin.career.application.show', $coverLetter->application),
                         ]),
            'message' => $message ?? '',
        ])

        @include('admin.components.show-row-link', [
            'name'  => 'date',
            'value' => longDate($coverLetter->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'content',
            'value' => $coverLetter->content
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'url',
            'href'   => $coverLetter->url,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $coverLetter->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($coverLetter->link_name) ? $coverLetter->link_name : 'link',
            'href'   => $coverLetter->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $coverLetter->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $coverLetter->disclaimer
                       ])
        ])

        @include('admin.components.show-row-images', [
            'resource' => $coverLetter,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $coverLetter,
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
