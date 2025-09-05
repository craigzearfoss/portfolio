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
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',            'url' => route('admin.career.communication.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        @include('admin.components.show-row', [
            'name'  => 'application_id',
            'value' => $communication->application_id ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'contact_id',
            'value' => $communication->contact_id ?? ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'subject',
            'value' => $communication->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'timestamp',
            'value' => longDateTime($communication->timestamp)
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

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($communication->deleted_at)
        ])

    </div>

@endsection
