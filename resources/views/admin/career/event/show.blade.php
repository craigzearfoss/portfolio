@extends('admin.layouts.default', [
    'title' => 'Event',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Events',          'url' => route('admin.career.event.index') ],
        [ 'name' => 'Show' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-pen-to-square"></i> Edit', 'url' => route('admin.career.event.edit', $event) ],
        [ 'name' => '<i class="fa fa-plus"></i> Add New Event', 'url' => route('admin.career.event.create') ],
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back',    'url' => route('admin.career.event.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div>

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $event->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'timestamp',
            'value' => longDateTime($event->timestamp)
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => $event->location
        ])

        @include('admin.components.show-row', [
            'name'  => 'attendees',
            'value' => $event->attendees
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $event->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'sequence',
            'value' => $event->sequence
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'public',
            'checked' => $event->public
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'readonly',
            'label'   => 'read-only',
            'checked' => $event->readonly
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'root',
            'checked' => $event->root
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'disabled',
            'checked' => $event->disabled
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($event->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($event->updated_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'deleted at',
            'value' => longDateTime($event->deleted_at)
        ])

    </div>

@endsection
