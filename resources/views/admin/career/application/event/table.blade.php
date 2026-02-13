@php
$events = $events ?? [];
@endphp
<table class="table admin-table">
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
                {!! $event->name !!}
            </td>
            <td>
                {{ longDate($event->date) }}
            </td>
            <td>
                {!! $event->time !!}
            </td>
            <td>
                {!! $event->location !!}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
