@php
    use App\Models\Career\Application;
    use Carbon\Carbon;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin         = $admin ?? null;
    $owner         = $owner ?? null;
    $isRootAdmin   = $isRootAdmin ?? false;
    $event         = $event ?? null;

    $title = getResourcePageTitle($event);
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
    $breadcrumbs[] = [ 'name' => 'Events', 'href' => route('admin.career.event.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($event, false) ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($event, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.career.event.edit', $event) ])->render();
    }
    if (canCreate($event, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Event',
                                                                  'href' => route('admin.career.event.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.career.event.index')] )->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="show-container card p-4">

        <div class="floating-div-container" style="max-width: 60rem;">

            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll">

                @include('admin.components.show-row', [
                    'name'  => 'id',
                    'value' => $event->id,
                    'hide'  => !$isRootAdmin,
                ])

                @include('admin.components.show-row', [
                    'name'  => 'owner',
                    'value' => $event->owner->username,
                    'hide'  => !$isRootAdmin,
                ])

                @php
                    $application = !empty($event->application_id)
                        ? Application::find($event->application_id)
                        : null;
                @endphp

                @include('admin.components.show-row-link', [
                    'label_name'  => 'application',
                    'label'       => !empty($application)
                                          ? (htmlspecialchars($application->company['name'] ?? '')) . ' - ' . htmlspecialchars($application->role) . ' [' . ($application->apply_date) . ']'
                                          : '',
                    'href'        => route('admin.career.application.show', $application)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'name',
                    'value' => htmlspecialchars($event->name)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'date',
                    'value' => longDate($event->event_datetime)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'time',
                    'value' => !empty($event->event_time)
                                   ? Carbon::createFromFormat('H:i:s', $event->event_time)->format('g:i a')
                                   : '',
                ])

                @include('admin.components.show-row', [
                    'name'  => 'location',
                    'value' => htmlspecialchars($event->location)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'attendees',
                    'value' => htmlspecialchars($event->attendees)
                ])

            </div>
            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 60rem;">

                @include('admin.components.show-row-link', [
                    'link_name' => 'link',
                    'name'      => $event->link,
                    'href'      => $event->link,
                    'target'    => '_blank',
                ])

                @include('admin.components.show-row', [
                    'name'  => 'link name',
                    'value' => $event->link_name,
                ])

                @include('admin.components.show-row', [
                    'name'  => 'description',
                    'value' => $event->description
                ])

            </div>
            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 60rem;">

                @include('admin.components.show-row', [
                    'name'  => 'disclaimer',
                    'value' => view('admin.components.disclaimer', [
                                    'value' => htmlspecialchars($event->disclaimer)
                               ])
                ])

                @include('admin.components.show-row', [
                    'name'  => 'notes',
                    'value' => nl2br(htmlspecialchars($event->notes))
                ])

                @include('admin.components.show-row-visibility', [
                    'resource' => $event,
                ])

                @include('admin.components.show-row', [
                    'name'  => 'created at',
                    'value' => longDateTime($event->created_at)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'updated at',
                    'value' => longDateTime($event->updated_at)
                ])

            </div>

        </div>

    </div>

@endsection
