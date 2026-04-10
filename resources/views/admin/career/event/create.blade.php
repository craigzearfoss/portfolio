@php
    use App\Models\Career\Application;
    use App\Models\System\Owner;

    $title = $pageTitle ?? 'Add Event' . (!empty($application) ? ' to ' . $application->name . ' application' : '');
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
            [ 'name' => 'Add' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Events',          'href' => route('admin.career.event.index') ],
            [ 'name' => 'Add' ]
        ];
    }

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.event.index')])->render(),
    ];

    // get the options for the application select list
    if (!empty($application->owner_id)) {
        $applicationListOptions = new Application()->listOptions(
            [ 'owner_id' => $application->owner_id ],
            'id',
            'name',
            true,
            false,
            [ 'name', 'asc' ]
        );
    } elseif ($isRootAdmin) {
        $applicationListOptions = new Application()->listOptions(
            [],
            'id',
            'name',
            true,
            false,
            [ 'name', 'asc' ]
        );
    } else {
        $applicationListOptions = new Application()->listOptions(
            [ 'owner_id' => $admin->id ],
            'id',
            'name',
            true,
            false,
            [ 'name', 'asc' ]
        );
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.event.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.event.index')
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $application->owner_id ?? '',
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @if(empty($application->id))
                @include('admin.components.form-select-horizontal', [
                    'name'    => 'application_id',
                    'label'   => 'application',
                    'value'   => old('application_id') ?? $application->id ?? '',
                    'list'    => $applicationListOptions,
                    'message' => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'    => 'application_id',
                    'value'   => $application->id,
                    'message' => $message ?? '',
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('subject') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'event_date',
                'value'   => old('event_date') ?? '',
                'message' => $message ?? '',
                'style'   => 'width: 15rem;',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'time',
                'name'    => 'event_time',
                'value'   => old('event_time') ?? '',
                'message' => $message ?? '',
                'style'   => 'width: 15rem;',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'location',
                'value'     => old('location') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'attendees',
                'value'     => old('attendees') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'text',
                'id'      => 'inputEditor',
                'value'   => old('text') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? 0,
                'is_readonly' => old('is_readonly') ?? 0,
                'is_root'     => old('is_root')     ?? 0,
                'is_disabled' => old('is_disabled') ?? 0,
                'is_demo'     => old('is_demo')     ?? 0,
                'sequence'    => old('sequence')    ?? 0,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Event',
                'cancel_url' => referer('admin.career.event.index')
            ])

        </form>

    </div>

@endsection
