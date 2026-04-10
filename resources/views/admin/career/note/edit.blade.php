@php
    use App\Models\Career\Application;
    use App\Models\System\Owner;

    $title    = $pageTitle ?? 'Edit Note' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Notes',              'href' => route('admin.career.note.index', ['application_id' => $application->id]) ],
            [ 'name' => 'Note',               'href' => route('admin.career.note.show', $note, ['application_id' => $application->id]) ],
            [ 'name' => 'Edit' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Notes',           'href' => route('admin.career.note.index') ],
            [ 'name' => 'Note',            'href' => route('admin.career.note.show', $note) ],
            [ 'name' => 'Edit' ]
        ];
    }

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.note.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.note.update', array_merge([$note], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.note.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $note->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of a note */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $note->owner_id
            ])

            <?php /*
            // you CANNOT change the application for a note
            @include('admin.components.form-hidden', [
                'name'    => 'application_id',
                'value'   => $communication->application_id,
                'message' => $message ?? '',
            ])
            */ ?>

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

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $note->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $note->link,
                'name' => old('link_name') ?? $note->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $note->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $note->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $note->is_public,
                'is_readonly' => old('is_readonly') ?? $note->is_readonly,
                'is_root'     => old('is_root')     ?? $note->is_root,
                'is_disabled' => old('is_disabled') ?? $note->is_disabled,
                'is_demo'     => old('is_demo')     ?? $note->is_demo,
                'sequence'    => old('sequence')    ?? $note->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.resume.index')
            ])

        </form>

    </div>

@endsection
