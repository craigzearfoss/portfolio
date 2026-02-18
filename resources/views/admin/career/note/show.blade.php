@php
    use App\Enums\PermissionEntityTypes;

    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Notes',            'href' => route('admin.career.note.index', ['application_id' => $application->id]) ],
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

    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $note, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.note.edit', $note)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'note', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Note', 'href' => route('admin.career.note.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.note.index')])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Note' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $note->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $note->owner->username
            ])
        @endif

        @php
            $application = !empty($note->application_id)
                ? \App\Models\Career\Application::find($note->application_id)
                : null;
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'application_id',
            'value' => !empty($application)
                ? ($application->company['name'] ?? '') . ' - ' . ($application->role) . ' [' . ($application->apply_date) . ']'
                : ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'subject',
            'value' => $note->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => $note->body
        ])

        @include('admin.components.show-row-settings', [
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
