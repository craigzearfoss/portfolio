@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Event',            'href' => route('admin.career.event.index', ['application_id' => $application->id]) ],
            [ 'name' => 'Event' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Events',          'href' => route('admin.career.event.index') ],
            [ 'name' => 'Event' ]
        ];
    }

    $buttons = [];
    if (canUpdate($event, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.event.edit', $event)])->render();
    }
    if (canCreate('event', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Event', 'href' => route('admin.career.event.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.event.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Event' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'      => $breadcrumbs,
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
            'value' => $event->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $event->owner->username
            ])
        @endif

        @php
            $application = !empty($event->application_id)
                ? \App\Models\Career\Application::find($event->application_id)
                : null;
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'application_id',
            'value' => !empty($application)
                ? ($application->company['name'] ?? '') . ' - ' . ($application->role) . ' [' . ($application->apply_date) . ']'
                : ''
        ])

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

        @include('admin.components.show-row-settings', [
            'resource' => $event,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($event->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($event->updated_at)
        ])

    </div>

@endsection
