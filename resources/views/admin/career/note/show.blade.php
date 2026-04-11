@php
    use App\Models\Career\Application;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $note        = $note ?? null;

    $title    = $pageTitle ?? 'Note' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
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
            [ 'name' => 'Note' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Notes',           'href' => route('admin.career.note.index') ],
            [ 'name' => 'Note' ]
        ];
    }

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($note, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.note.edit', $note)])->render();
    }
    if (canCreate($note, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Note', 'href' => route('admin.career.note.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.note.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $note->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $note->owner->username,
            'hide'  => !$isRootAdmin,
        ])

        @php
            $application = !empty($note->application_id)
                ? Application::find($note->application_id)
                : null;
        @endphp
        @include('admin.components.show-row-link', [
            'name'  => 'application',
            'label' => $application
                ? ($application->company['name'] ?? '') . ' - ' . ($application->role) . ' [' . ($application->apply_date) . ']'
                : '',
            'href' => route('admin.career.application.show', $application)
        ])

        @include('admin.components.show-row', [
            'name'  => 'subject',
            'value' => $note->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => $note->body
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $note->notes
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $note->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => $note->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $note->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $note->disclaimer
                       ])
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $note,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($note->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($note->updated_at)
        ])

    </div>

@endsection
