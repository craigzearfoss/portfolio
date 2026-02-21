@php
    use App\Models\Career\Application;
    use App\Models\Career\CommunicationType;
    use App\Models\System\Owner;

    $title    = $pageTitle ?? 'Edit Communication' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Communications',   'href' => route('admin.career.communication.index', ['application_id' => $application]) ],
            [ 'name' => 'Communication',    'href' => route('admin.career.communication.show', $communication, ['application_id' => $application->id])],
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
@endphp
@extends('admin.layouts.default', [
    'title'         => $title,
    'subtitle'      => $subtitle,
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.communication.index') ])->render(),
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'menuService'   => $menuService,
    'admin'         => $admin,
    'user'          => $user,
    'owner'         => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.communication.update', array_merge([$communication], request()->all())) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.communication.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $communication->id
            ])

            @if($admin->root)
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
                'value'     => old('to') ?? $event->to,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'from',
                'value'     => old('from') ?? $event->from,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'date',
                'value'   => old('timestamp') ?? $communication->date,
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
                'public'      => old('public') ?? $communication->public,
                'readonly'    => old('readonly') ?? $communication->readonly,
                'root'        => old('root') ?? $communication->root,
                'disabled'    => old('disabled') ?? $communication->disabled,
                'demo'        => old('demo') ?? $communication->demo,
                'sequence'    => old('sequence') ?? $communication->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.communication.index')
            ])

        </form>

    </div>

@endsection
