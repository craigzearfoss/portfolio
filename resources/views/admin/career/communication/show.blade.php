@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Communications',   'href' => route('admin.career.communication.index', ['application_id' => $application->id]) ],
            [ 'name' => 'Communication' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Communications',  'href' => route('admin.career.communication.index') ],
            [ 'name' => 'Communication' ]
        ];
    }
@endphp
@extends('admin.layouts.default', [
    'title' => $title ?? 'Communication' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs' => $breadcruumbs,
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',         'href' => route('admin.career.communication.edit', $communication) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Communication', 'href' => route('admin.career.communication.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',            'href' => referer('admin.career.communication.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $communication->id
        ])

        @if(isRootAdmin())
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $communication->owner['username'] ?? ''
            ])
        @endif

        @php
            $application = !empty($communication->application_id)
                ? \App\Models\Career\Application::find($communication->application_id)
                : null;
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'application_id',
            'value' => !empty($application)
                ? ($application->company['name'] . ' - ' . $application->role . ' [' . $application->apply_date . ']')
                : ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'type',
            'value' => $communication->communicationType->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'subject',
            'value' => $communication->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDateTime($communication->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'time',
            'value' => $communication->time
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => nl2br($communication->body ?? '')
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $communication->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $communication->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $communication->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $communication->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $communication->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($communication->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($communication->updated_at)
        ])

    </div>

@endsection
