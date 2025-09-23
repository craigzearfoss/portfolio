@extends('admin.layouts.default', [
    'title' => 'Note',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Notes',           'url' => route('admin.career.note.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.career.note.edit', $note) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Note',  'url' => route('admin.career.note.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => referer('admin.career.note.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $note->id
        ])

        @php
            $application = !empty($note->application_id)
                ? \App\Models\Career\Application::find($note->application_id)
                : null;
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'application_id',
            'value' => !empty($application)
                ? ($application->company['name'] . ' - ' . $application->role . ' [' . $application->apply_date . ']')
                : ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'subject',
            'value' => $note->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => $note->body
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $note->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $note->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $note->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $note->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $note->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($note->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($note->updated_at)
        ])

    </div>

@endsection
