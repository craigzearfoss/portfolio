@php
    use App\Models\Career\Application;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $note        = $note ?? null;

    $title    = getResourcePageTitle($note);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                      'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',   'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',       'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Applications', 'href' => route('admin.career.application.index') ];
    $breadcrumbs[] = [ 'name' => 'Notes',        'href' => route('admin.career.note.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($note, false) ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($note, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.note.edit', $note) ])->render();
    }
    if (canCreate($note, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Note',
                                                                  'href' => route('admin.career.note.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.note.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        <div class="floating-div-container" style="max-width: 60rem;">

            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll">

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
                    'link_name' => 'application',
                    'name'      => $application
                                       ? (htmlspecialchars($application->company['name'] ?? '')) . ' - ' . htmlspecialchars($application->role) . ' [' . ($application->apply_date) . ']'
                                       : '',
                    'href' => route('admin.career.application.show', $application)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'subject',
                    'value' => htmlspecialchars($note->subject)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'body',
                    'value' => htmlspecialchars($note->body)
                ])

            </div>
            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 60rem;">

                @include('admin.components.show-row-link', [
                    'link_name' => htmlspecialchars($note->link_name ?? 'link'),
                    'name'      => $note->link,
                    'href'      => $note->link,
                    'target'    => '_blank',
                ])

                @include('admin.components.show-row', [
                    'name'  => 'description',
                    'value' => $note->description
                ])

            </div>
            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 60rem;">

                @include('admin.components.show-row', [
                    'name'  => 'disclaimer',
                    'value' => view('admin.components.disclaimer', [
                                    'value' => htmlspecialchars($note->disclaimer)
                               ])
                ])

                @include('admin.components.show-row', [
                    'name'  => 'notes',
                    'value' => nl2br(htmlspecialchars($note->notes))
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

        </div>

    </div>

@endsection
