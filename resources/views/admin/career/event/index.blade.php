@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',             'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard',  'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',           'href' => route('admin.career.index') ],
            [ 'name' => 'Applications' ,    'href' => route('admin.career.application.index') ],
            [ 'name' => $application->name, 'href' => route('admin.career.application.show', $application->id) ],
            [ 'name' => 'Events' ]
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('system.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Career',          'href' => route('admin.career.index') ],
            [ 'name' => 'Events' ]
        ];
    }
@endphp
@extends('admin.layouts.default', [
    'title' => $title ?? 'Events' . (!empty($application) ? ' for ' . $application->name . ' application' : ''),
    'breadcrumbs' => $breadcrumbs,
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Event', 'href' => route('admin.career.event.create', !empty($application) ? ['application_id' => $application->id] : []) ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($application))
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
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($application))
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
            */ ?>
            <tbody>

            @forelse ($events as $event)

                <tr data-id="{{ $event->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $event->owner->username ?? '' }}
                        </td>
                    @endif
                    @if(empty($application))
                        <td data-field="application_id">
                            @include('admin.components.link', [
                                'name' => $event->application->name,
                                'href' => route('admin.career.application.show', event->application->id)
                            ])
                        </td>
                    @endif
                    <td data-field="application_id" style="white-space: nowrap;">
                        {{ $event->application->name ?? '' }}
                    </td>
                    <td data-field="name" style="white-space: nowrap;">
                        {{ $event->name }}
                    </td>
                    <td data-field="date" style="white-space: nowrap;">
                        {{ shortDate($event->date) }}
                    </td>
                    <td data-field="time" style="white-space: nowrap;">
                        {{ $event->time }}
                    </td>
                    <td data-field="location" style="white-space: nowrap;">
                        {{ $event->location }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $event->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $event->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.event.destroy', $event->id) }}" method="POST">

                            @if(canRead($event))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.event.show', $event->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canRead($event))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.career.event.edit', $event->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if(canDelete($event))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    @php
                    $colspan = isRootAdmin() ? '8' : '7';
                    if (!empty($application)) $colspan = $colspan++;
                    @endphp
                    <td colspan="{{ $colspan }}">There are no events.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $events->links('vendor.pagination.bulma') !!}

    </div>

@endsection
