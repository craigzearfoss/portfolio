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
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',     'url' => route('admin.career.resume.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

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

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'url'    => $resume->link,
            'target' => 'blank'
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'alt link',
            'url'    => $resume->alt_link,
            'target' => 'blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $resume->description
        ])
        @include('admin.components.show-row-checkbox', [
            'name'    => 'primary',
            'checked' => $resume->primary
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $resume->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $resume->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $resume->admin['username'] ?? ''
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
