@php
    use App\Models\Career\Application;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $event         = $event ?? null;

    $title    = 'Edit ' . getResourcePageTitle($event);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                           'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                        'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',                            'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications',                      'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Events',                            'href' => route('admin.career.event.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($event, false), 'href' => route('admin.career.event.show', $event) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.event.index') ])->render()
    ];

    // get the options for the application select list
    $applicationListOptions = new Application()->filteredListOptions($admin, $application->owner_id ?? null);
@endphp

@extends('admin.layouts.default')

@section('content')

    @if (empty($applicationListOptions))

        <div class="edit-container form-container p-4">
            <p>There are no applications to attach an event to.</p>
        </div>

    @else

        <div class="edit-container card form-container p-4">

            <form action="{{ route('admin.career.event.update', array_merge([$event], request()->all())) }}"
                  class="admin-form"
                  method="POST"
            >
                @csrf
                @method('PUT')

                @include('admin.components.form-hidden', [
                    'name'  => 'referer',
                    'value' => request()->query('referer') ?? referer('admin.career.event.index')
                ])

                <div class="floating-div-container">

                    <div class="floating-div card admin-form-card">

                        @if ($isRootAdmin)
                            @include('admin.components.favorites-box-form-input', [
                                'name'  => 'favorite_count',
                                'label' => 'favorites',
                                'value' => old('favorite_count') ?? $event->favorite_count,
                            ])
                        @endif

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
                            'name'    => 'event_datetime',
                            'label'   => 'event datetime',
                            'value'   => old('event_datetime') ?? $event->event_datetime,
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

                    </div>

                </div>
                <div class="floating-div-container">

                    <div class="floating-div card admin-form-card">

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


                    </div>

                </div>
                <div class="floating-div-container">

                    <div class="floating-div card admin-form-card">

                        @include('admin.components.form-input-horizontal', [
                            'name'        => 'disclaimer',
                            'value'       => old('disclaimer') ?? $event->disclaimer,
                            'maxlength'   => 500,
                            'message'     => $message ?? '',
                        ])

                        @include('admin.components.form-textarea-horizontal', [
                            'name'    => 'notes',
                            'value'   => old('notes') ?? $event->notes,
                            'message' => $message ?? '',
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

                    </div>

                </div>

                @include('admin.components.form-button-submit-horizontal', [
                    'label'      => 'Save',
                    'cancel_url' => referer('admin.career.event.index')
                ])

            </form>

        </div>

    @endif

@endsection
