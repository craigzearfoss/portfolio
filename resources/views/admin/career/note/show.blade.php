@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Notes',            'href' => route('admin.career.note.index', ['application_id' => $application->id]) ],
            [ 'name' => 'Note' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Notes',           'href' => route('admin.career.note.index') ],
            [ 'name' => 'Note' ]
        ];
    }

    $buttons = [];
    if (canUpdate($note)) {
        $buttons[] = [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'href' => route('admin.career.note.edit', $note) ];
    }
    if (canCreate($note)) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Note', 'href' => route('admin.career.note.create') ];
    }
    $buttons[] = [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'href' => referer('admin.career.note.index') ];
@endphp
@extends('admin.layouts.default', [
    'title' => $title ?? 'Note' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs' => $breadcrumbs,
    'buttons' => $buttons,
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
                'value' => $note->owner->username ?? ''
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
            'value' => htmlspecialchars($note->subject)
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => nl2br($note->body ?? '')
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $note,
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
