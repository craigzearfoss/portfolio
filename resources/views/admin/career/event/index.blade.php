@php
    use Carbon\Carbon;
    use App\Enums\PermissionEntityTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Event;

    $title    = $pageTitle ?? 'Events' . (!empty($application) ? ' for ' . $application->name . ' application' : '');
    $subtitle = $title;

    // set breadcrumbs
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',               'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',    'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',             'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,      'href' => route('admin.career.application.index') ],
            [ 'name' => $application['name'], 'href' => route('admin.career.application.show', $application) ],
            [ 'name' => 'Events' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Events' ]
        ];
    }

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Event::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Event', 'href' => route('admin.career.event.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-event',
        [ 'action'     => route('admin.career.event.index'),
          'owner_id'   => $isRootAdmin ? null : $owner->id,
        ]
    )

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $events->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>application</th>
                        <th>name</th>
                        <th class="has-text-centered">date</th>
                        <th class="has-text-centered">time</th>
                        <th>location</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>application</th>
                        <th>name</th>
                        <th class="has-text-centered">date</th>
                        <th class="has-text-centered">time</th>
                        <th>location</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($events as $event)

                    <tr data-id="{{ $event->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $event->owner->username }}
                            </td>
                        @endif
                        <td data-field="application_id">
                            @include('admin.components.link', [
                                'name' => $event->application->name ?? '',
                                'href' => route('admin.career.application.show',
                                              Application::find($event->application->id)
                                          )
                            ])
                        </td>
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $event->name !!}
                        </td>
                        <td data-field="event_date" class="has-text-centered" style="white-space: nowrap;">
                            {{ shortDate($event->event_date) }}
                        </td>
                        <td data-field="event_time" class="has-text-centered" style="white-space: nowrap;">
                            {{ !empty($event->event_time)
                                   ? Carbon::createFromFormat('H:i:s', $event->event_time)->format('g:i a')
                                   : ''
                            }}
                        </td>
                        <td data-field="location" style="white-space: nowrap;">
                            {!! $event->location !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $event->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $event->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($event, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.event.show', $event),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($event, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.event.edit', $event),
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

                                @if(canDelete($event, $admin))
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
                        @php
                            $colspan = $isRootAdmin ? '9' : '8';
                        @endphp
                        <td colspan="{{ $colspan }}">No events found.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $events->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
