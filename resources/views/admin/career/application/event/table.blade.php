@php
    use Carbon\Carbon;

    $events = $events ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th class="has-text-centered">date</th>
    <th class="has-text-centered">time</th>
    <th>location</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($events as $event)

        <tr data-id="{{ $event->id }}">
            <td>
                {!! $event->name !!}
            </td>
            <td class="has-text-centered">
                {{ shortDate($event->event_datetime) }}
            </td>
            <td class="has-text-centered">
                {{ !empty($event->event_time)
                       ? Carbon::createFromFormat('H:i:s', $event->event_time)->format('g:i a')
                       : ''
                }}
            </td>
            <td>
                {!! $event->location !!}
            </td>
            <td class="is-1">

                <div class="action-button-panel">

                    @if(canRead($event, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'show',
                            'href'  => route('admin.career.event.show', [
                                                   $event,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-list'
                        ])
                    @endif

                    @if(canUpdate($event, $admin))
                        @include('admin.components.link-icon', [
                            'title' => 'edit',
                            'href'  => route('admin.career.event.edit', [
                                                   $event,
                                                   'referer' => url()->current()
                                             ]),
                            'icon'  => 'fa-pen-to-square'
                        ])
                    @endif

                    @if(canDelete($event, $admin))
                        <form class="delete-resource"
                              action="{!! route('admin.career.event.destroy', $event) !!}"
                              method="POST">
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

    @endforeach

    </tbody>
</table>
