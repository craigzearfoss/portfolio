@php
    use App\Models\Career\Application;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $communication = $communication ?? null;

    $title    = getResourcePageTitle($communication);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                        'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',             'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',         'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications',   'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Communications', 'href' => route('admin.career.communication.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($communication, false) ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($communication, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.communication.edit', $communication) ])->render();
    }
    if (canCreate($communication, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Communication',
                                                                  'href' => route('admin.career.communication.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.communication.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $communication->id,
            'hide'  => !$isRootAdmin,
        ])

        @include('admin.components.show-row', [
            'name'  => 'owner',
            'value' => $communication->owner->username,
            'hide'  => !$isRootAdmin,
        ])

        @php
            $application = !empty($communication->application_id)
                ? Application::find($communication->application_id)
                : null;
        @endphp
        @include('admin.components.show-row-link', [
            'name'  => 'application',
            'label' => !empty($application)
                ? (($application->company['name'] ?? '') . ' - ' . ($application->role) . ' [' . ($application->apply_date) . ']')
                : '',
            'href' => route('admin.career.application.show', $application)
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
            'value' => $communication->to
        ])

        @include('admin.components.show-row', [
            'name'  => 'from',
            'value' => $communication->from
        ])

        @include('admin.components.show-row', [
            'name'  => 'datetime',
            'value' => longDateTime($communication->communication_datetime)
        ])

        @include('admin.components.show-row', [
            'name'  => 'body',
            'value' => $communication->body
        ])

        @include('admin.components.show-row-link', [
            'name'   => 'link',
            'href'   => $communication->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'   => 'link name',
            'label'  => 'link_name',
            'value'  => $communication->link_name,
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $communication->description
        ])

        @include('admin.components.show-row', [
            'name'  => 'disclaimer',
            'value' => view('admin.components.disclaimer', [
                            'value' => $communication->disclaimer
                       ])
        ])

        @include('admin.components.show-row', [
            'name'  => 'notes',
            'value' => $communication->notes
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
