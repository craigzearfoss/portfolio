@php
    use Carbon\Carbon;
    use App\Models\Career\Application;
    use App\Models\Career\Event;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\Event';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Events' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
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
    $breadcrumbs[] = [ 'name' => 'Events' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Event::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Event',
                                                                  'href' => route('admin.career.event.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-event', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.event.export', request()->except([ 'page' ])),
                'filename' => 'events_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($events->total()) }} {{ ($events->total() === 1) ? 'event' : 'events' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $events->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the event is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}" style="min-width: 60rem; max-width: 90rem; overflow-x: auto; overflow-y: hidden;">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>application</th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'name|asc',
                            ])
                        </th>
                        <th class="has-text-centered">
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'datetime',
                                'sort'  => 'event_datetime|desc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'location',
                                'sort'  => 'location|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'attendees',
                                'sort'  => 'attendees|asc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($events as $event)

                    <tr data-id="{{ $event->id }}" {!! $event->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $event->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $event->owner->username,
                                    'href'  => route('admin.system.admin.show', $event->owner),
                                    'class' => $event->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        <td data-field="application_id" style="white-space: nowrap;">
                            @if (!empty($event->application))
                                @include('admin.components.link', [
                                    'name'            => htmlspecialchars($event->application->name),
                                    'href'            => route('admin.career.application.show',
                                                          Application::find($event->application->id)
                                                      ),
                                    'class'           => $event->is_disabled ? [ 'disabled-text' ] : [],
                                    'style'           => [ 'display: inline-block', 'max-width: 20rem', 'overflow-x: hidden' ],
                                    'title_attribute' => $event->application->name,
                                ])
                            @endif
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'            => $event->name,
                                'href'            => route('admin.career.event.show', $event),
                                'class'           => $event->is_disabled ? [ 'disabled-text' ] : [],
                                'style'           => [ 'display: inline-block', 'max-width: 20rem', 'overflow-x: hidden' ],
                                'title_attribute' => $event->name,
                            ])
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'career.event', 'data-id' => $event->id ]
                           ])
                        </td>
                        <td data-field="event_datetime" class="has-text-centered" style="white-space: nowrap;">
                            {{ shortDateTime($event->event_datetime) }}
                        </td>
                        <td data-field="event_time" class="has-text-centered" style="white-space: nowrap;">
                            {{ !empty($event->event_time)
                                   ? Carbon::createFromFormat('H:i:s', $event->event_time)->format('g:i a')
                                   : ''
                            }}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {!! htmlspecialchars($event->location) !!}
                        </td>
                        <td data-field="attendees" style="white-space: nowrap;">
                            {!! htmlspecialchars($event->attendees) !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $event->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $event->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($event, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.event.show', ownerParams($event, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($event, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.event.edit',
                                                          ownerParams($event, request()->input('owner_id'), $admin)
                                                   ),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($event->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($event->link_name) ? $event->link_name : 'link',
                                        'href'   => $event->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if (canDelete($event, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.event.destroy', $event) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ $isRootAdmin ? '10' : '8' }}">No events found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $events->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
