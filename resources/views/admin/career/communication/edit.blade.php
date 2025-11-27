@extends('admin.layouts.default', [
    'title' => $title ?? 'Edit Communication',
    'breadcrumbs' => [
        [ 'name' => 'Home',                            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',                 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',                          'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',                    'href' => route('admin.career.application.index') ],
        [ 'name' => $communication->application->name, 'href' => route('admin.career.application.show', $communication->application->id) ],
        [ 'name' => 'Communications',                  'href' => route('admin.career.communication.index', ['application_id' => $communication->application->id]) ],
        [ 'name' => 'Communication' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.communication.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.communication.update', $communication->id) }}" method="POST">
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

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $communication->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
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
                'list'    => \App\Models\Career\Application::listOptions([], 'id', 'name', true),
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

            @include('admin.components.form-settings-horizontal', [
                'public'   => $communication->public,
                'readonly' => $communication->readonly,
                'root'     => $communication->root,
                'disabled' => $communication->disabled,
                'demo'     => $communication->demo,
                'sequence' => $communication->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.communication.index')
            ])

        </form>

    </div>

@endsection
