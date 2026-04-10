@php
    use App\Models\Career\Application;
    use App\Models\System\Owner;

    $title    = $pageTitle ?? 'Edit Event' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Events',             'href' => route('admin.career.event.index', ['application_id' => $application->id]) ],
            [ 'name' => 'Event',              'href' => route('admin.career.event.show', $event, ['application_id' => $application->id]) ],
            [ 'name' => 'Edit' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Events',          'href' => route('admin.career.event.index') ],
            [ 'name' => 'Event',           'href' => route('admin.career.event.show', $event) ],
            [ 'name' => 'Edit' ]
        ];
    }

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.event.index')])->render()
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.event.update', array_merge([$event], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => request()->query('referer') ?? referer('admin.career.event.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $event->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of an event */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $event->owner_id
            ])

            <?php /* note you CANNOT change the application for an event */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'application_id',
                'value' => $event->application_id,
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $event->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'event_date',
                'value'   => old('event_date') ?? $event->event_date,
                'message' => $message ?? '',
                'style'   => 'width: 15rem;',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'time',
                'name'    => 'event_time',
                'value'   => old('event_time') ?? $event->event_time,
                'message' => $message ?? '',
                'style'   => 'width: 15rem;',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'location',
                'value'     => old('location') ?? $event->location,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'attendees',
                'value'     => old('attendees') ?? $event->attendees,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'text',
                'id'      => 'inputEditor',
                'value'   => old('text') ?? $event->text,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $event->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $event->link,
                'name' => old('link_name') ?? $event->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $event->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $event->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $event->is_public,
                'is_readonly' => old('is_readonly') ?? $event->is_readonly,
                'is_root'     => old('is_root')     ?? $event->root,
                'is_disabled' => old('is_disabled') ?? $event->is_disabled,
                'is_demo'     => old('is_demo')     ?? $event->is_demo,
                'sequence'    => old('sequence')    ?? $event->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.event.index')
            ])

        </form>

    </div>

@endsection
