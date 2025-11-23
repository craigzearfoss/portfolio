@extends('admin.layouts.default', [
    'title' => 'Note',
    'breadcrumbs' => [
        [ 'name' => 'Home',                    'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',                  'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',            'href' => route('admin.career.application.index') ],
        [ 'name' => $note->application->name,  'href' => route('admin.career.application.show', $note->application->id) ],
        [ 'name' => 'Notes',                   'href' => route('admin.career.communication.index', ['application_id' => $note->application->id]) ],
        [ 'name' => 'Note' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.note.edit', $note) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Note',  'href' => route('admin.career.note.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.career.note.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $note->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $note->owner['username'] ?? ''
            ])
        @endif

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
            'value' => nl2br($note->body ?? '')
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
