@php
    use App\Models\Career\Application;
    use App\Models\Career\CommunicationType;
    use App\Models\System\Owner;

    $title    = $pageTitle ?? 'Edit Communication' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Communications',     'href' => route('admin.career.communication.index', ['application_id' => $application]) ],
            [ 'name' => 'Communication',      'href' => route('admin.career.communication.show', $communication, ['application_id' => $application->id])],
            [ 'name' => 'Edit' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Communications',  'href' => route('admin.career.communication.index') ],
            [ 'name' => 'Communication',   'href' => route('admin.career.communication.show', $communication) ],
            [ 'name' => 'Edit' ]
        ];
    }

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.communication.index')])->render()
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.communication.update', array_merge([$communication], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => request()->query('referer') ?? referer('admin.career.communication.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $communication->id
            ])

            @if($isRootAdmin)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $communication->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $communication->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'    => 'application_id',
                'label'   => 'application',
                'value'   => old('application_id') ?? $communication->application_id,
                'list'    => new Application()->listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'communication_type_id',
                'label'   => 'type',
                'value'   => old('communication_type_id') ?? $communication->communication_type_id,
                'list'    => new CommunicationType()->listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'subject',
                'value'     => old('subject') ?? $communication->subject,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'to',
                'value'     => old('to') ?? $communication->to,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'from',
                'value'     => old('from') ?? $communication->from,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'date',
                'value'   => old('date') ?? $communication->date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'time',
                'name'    => 'time',
                'value'   => old('time') ?? $communication->time,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'body',
                'id'      => 'inputEditor',
                'value'   => old('body') ?? $communication->body,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $communication->is_public,
                'is_readonly' => old('is_readonly') ?? $communication->is_readonly,
                'is_root'     => old('is_root')     ?? $communication->root,
                'is_disabled' => old('is_disabled') ?? $communication->is_disabled,
                'is_demo'     => old('is_demo')     ?? $communication->is_demo,
                'sequence'    => old('sequence')    ?? $communication->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.communication.index')
            ])

        </form>

    </div>

@endsection
