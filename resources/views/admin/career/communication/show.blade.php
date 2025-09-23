@php \App\Models\Career\Application::listOptions(); @endphp
@extends('admin.layouts.default', [
    'title' => 'Communication',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Communications',  'url' => route('admin.career.communication.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit',         'url' => route('admin.career.communication.edit', $communication) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Communication', 'url' => route('admin.career.communication.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',            'url' => referer('admin.career.communication.index') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $communication->id
        ])

        @php
            $application = !empty($note->application_id)
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
            'value' => $communication->body
        ])

        @include('admin.components.show-row', [
            'name'    => 'sequence',
            'checked' => $communication->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $communication->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'     => 'readonly',
            'readonly' => 'read-only',
            'checked'  => $communication->readonly
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
            'name'  => 'owner',
            'value' => $communication->admin['username'] ?? ''
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
