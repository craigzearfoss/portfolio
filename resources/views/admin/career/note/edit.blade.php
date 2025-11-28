@extends('admin.layouts.default', [
    'title' => $title ?? 'Edit Note',
    'breadcrumbs' => [
        [ 'name' => 'Home',                    'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',                  'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',            'href' => route('admin.career.application.index') ],
        [ 'name' => $note->application->name, 'href' => route('admin.career.application.show', $note->application->id) ],
        [ 'name' => 'Notes',                  'href' => route('admin.career.communication.index', ['application_id' => $note->application->id]) ],
        [ 'name' => 'Note' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.note.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.note.update', $note->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.note.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $note->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $note->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $note->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'    => 'application_id',
                'label'   => 'application',
                'value'   => old('application_id') ?? $note->application_id,
                'list'    => \App\Models\Career\Application::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'subject',
                'value'     => old('subject') ?? $note->subject,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'body',
                'id'      => 'inputEditor',
                'value'   => old('body') ?? $note->body,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $note->public,
                'readonly' => old('readonly') ?? $note->readonly,
                'root'     => old('root') ?? $note->root,
                'disabled' => old('disabled') ?? $note->disabled,
                'demo'     => old('demo') ?? $note->demo,
                'sequence' => old('sequence') ?? $note->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.note.index')
            ])

        </form>

    </div>

@endsection
