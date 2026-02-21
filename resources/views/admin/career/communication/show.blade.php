@php
    use App\Enums\PermissionEntityTypes;

    $title    = $pageTitle ?? 'Communication' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    $buttons = [];
    if (canUpdate(PermissionEntityTypes::RESOURCE, $communication, $admin)) {
        $buttons[] = view('admin.components.nav-button-edit', ['href' => route('admin.career.communication.edit', $communication)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'communication', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Communication', 'href' => route('admin.career.communication.create')])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', ['href' => referer('admin.career.communication.index')])->render();
@endphp
@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Communications',   'href' => route('admin.career.communication.index', ['application_id' => $application->id]) ],
            [ 'name' => 'Communication' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Communications',  'href' => route('admin.career.communication.index') ],
            [ 'name' => 'Communication' ]
        ];
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $communication->id
        ])

        @if($admin->root)
            @include('admin.components.show-row', [
                'name'  => 'owner',
                'value' => $communication->owner->username
            ])
        @endif

        @php
            $application = !empty($communication->application_id)
                ? \App\Models\Career\Application::find($communication->application_id)
                : null;
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'application_id',
            'value' => !empty($application)
                ? (($application->company['name'] ?? '') . ' - ' . ($application->role) . ' [' . ($application->apply_date) . ']')
                : ''
        ])

        @include('admin.components.show-row', [
            'name'  => 'type',
            'value' => $communication->communicationType->name
        ])

        @include('admin.components.show-row', [
            'name'  => 'subject',
            'value' => $communication->subject
        ])

        @include('admin.components.show-row', [
            'name'  => 'to',
            'value' => $event->to
        ])

        @include('admin.components.show-row', [
            'name'  => 'from',
            'value' => $event->from
        ])

        @include('admin.components.show-row', [
            'name'  => 'date',
            'value' => longDateTime($communication->date)
        ])

        @include('admin.components.show-row', [
            'name'  => 'time',
            'value' => $communication->time
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => $communication->body
        ])

        @include('admin.components.show-row-visibility', [
            'resource' => $communication,
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($communication->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($communication->updated_at)
        ])

    </div>

@endsection
