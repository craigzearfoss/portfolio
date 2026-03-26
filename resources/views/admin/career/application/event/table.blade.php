@php
    $events = $events ?? [];
@endphp
<table class="table admin-table {{ $adminTableClasses ?? '' }}">
    <thead>
    <th>name</th>
    <th>date</th>
    <th>time</th>
    <th>location</th>
    <th>actions</th>
    </thead>
    <tbody>

    @foreach($events as $event)

        <tr>
            <td>
                {!! $event->name !!}
            </td>
            <td>
                {{ longDate($event->date) }}
            </td>
            <td>
                {{ !empty($event->time) ? date("g:i a", strtotime($event->time)) : '' }}
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
