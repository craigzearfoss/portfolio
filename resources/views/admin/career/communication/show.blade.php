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
        <div class="floating-div-container" style="max-width: 60rem;">

            @if ($isRootAdmin)
                @include('admin.components.favorites-box', [ 'label' => 'favorites', 'count' => $communication->favorite_count ])
            @endif

            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll">

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
                    'link_name' => 'application',
                    'name'      => !empty($application)
                                       ? (($application->company['name'] ?? '') . ' - ' . ($application->role) . ' [' . ($application->apply_date) . ']')
                                       : '',
                    'href'      => route('admin.career.application.show', $application)
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
                    'value' => htmlspecialchars($communication->to)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'from',
                    'value' => htmlspecialchars($communication->from)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'datetime',
                    'value' => longDateTime($communication->communication_datetime)
                ])

                @include('admin.components.show-row', [
                    'name'  => 'body',
                    'value' => $communication->body
                ])

            </div>

        </div>
        <div class="floating-div-container">

            <div class="floating-div card has-background-white-ter p-4 m-2 no-x-scroll" style="width: 60rem;">

                @include('admin.components.show-row', [
                    'name'  => 'link',
                    'value' => $communication->link
                               . (!empty($communication->link)
                                    ? view('admin.components.link-icon', [
                                          'title'  => 'open link in new window',
                                          'href'   => $communication->link,
                                          'icon'   => 'fa-external-link',
                                          'border' => false,
                                          'target' => '_blank',
                                          'style'  => [ 'margin-top: -4px' ]
                                      ])
                                   : '')
                ])

                @include('admin.components.show-row', [
                    'name'  => 'link name',
                    'value' => $communication->link_name,
                ])

                @include('admin.components.show-row', [
                    'name'  => 'description',
                    'value' => $communication->description
                ])

                @include('admin.components.show-row', [
                    'name'  => 'disclaimer',
                    'value' => view('admin.components.disclaimer', [
                                    'value' => htmlspecialchars($communication->disclaimer)
                               ])
                ])

                @include('admin.components.show-row', [
                    'name'  => 'notes',
                    'value' => nl2br(htmlspecialchars($communication->notes))
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

        </div>
    </div>

@endsection
