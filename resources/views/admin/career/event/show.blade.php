@php
    use App\Models\Career\Application;
    use Carbon\Carbon;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $event         = $event ?? null;

    $title = $pageTitle ?? 'Event' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Event',              'href' => route('admin.career.event.index', ['application_id' => $application->id]) ],
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

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($event, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.event.edit', $event)])->render();
    }
    if (canCreate($event, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Event', 'href' => route('admin.career.event.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.event.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $event->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $event->owner->username,
            'hide'  => !$isRootAdmin,
        ])

        @php
            $application = !empty($event->application_id)
                ? Application::find($event->application_id)
                : null;
        @endphp
        @include('admin.components.show-row-link', [
            'name'  => 'application',
            'label' => !empty($application)
                ? ($application->company['name'] ?? '') . ' - ' . ($application->role) . ' [' . ($application->apply_date) . ']'
                : '',
            'href' => route('admin.career.application.show', $application)
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $event->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDate($event->event_datetime)
        ])

        @include('admin.components.show-row', [
            'name'  => 'time',
            'value' => !empty($event->event_time)
                           ? Carbon::createFromFormat('H:i:s', $event->event_time)->format('g:i a')
                           : '',
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => $event->location
        ])

        @include('admin.components.show-row', [
            'name'  => 'attendees',
            'value' => $event->attendees
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $event->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => $event->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $event->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $event->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => $event->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $event->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $event->disclaimer
                       ])
        ])

        @include('admin.components.show-row-visibility', [
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
