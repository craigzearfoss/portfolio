@php
$events = $events ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
    <thead>
    <th>name</th>
    <th>date</th>
    <th>time</th>
    <th>location</th>
    </thead>
    <tbody>

    @foreach($events as $event)

        <tr>
            <td>
                {!! htmlspecialchars($event['name']) !!}
            </td>
            <td>
                {{ longDate($event->date) }}
            </td>
            <td>
                {{ $event->time }}
            </td>
            <td>
                {!! htmlspecialchars($event->location) !!}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
