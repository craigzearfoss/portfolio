@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application) ],
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

    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'event', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Event', 'href' => route('admin.career.event.create')])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Events' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if($isRootAdmin)
        @include('admin.components.search-panel.owner', [ 'action' => route('admin.career.event.index') ])
    @endif

    <div class="card p-4">

        @if($pagination_top)
            {!! $events->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                @if(!empty($event->application))
                    <th>application</th>
                @endif
                <th>name</th>
                <th>date</th>
                <th>time</th>
                <th>location</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    @if(!empty($event->application))
                        <th>application</th>
                    @endif
                    <th>name</th>
                    <th>date</th>
                    <th>time</th>
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
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $event->owner->username }}
                        </td>
                    @endif
                    @if(!empty($event->application))
                        <td data-field="application_id">
                            @include('admin.components.link', [
                                'name' => $event->application->name ?? '',
                                'href' => route('admin.career.application.show',
                                                \App\Models\Career\Application::find($event->application->id)
                                          )
                            ])
                        </td>
                    @endif
                    <td data-field="name" style="white-space: nowrap;">
                        {!! $event->name !!}
                    </td>
                    <td data-field="date" style="white-space: nowrap;">
                        {{ shortDate($event->date) }}
                    </td>
                    <td data-field="time" style="white-space: nowrap;">
                        {!! $event->time !!}
                    </td>
                    <td data-field="location" style="white-space: nowrap;">
                        {!! $event->location !!}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $event->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $event->disabled ])
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $event, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.career.event.show', $event),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $event, $admin))
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

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $event, $admin))
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
                        $colspan = $admin->root ? '8' : '7';
                        if (!empty($application)) $colspan = $colspan++;
                    @endphp
                    <td colspan="{{ $colspan }}">There are no events.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $events->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
