@php
$communications = $communications ?? [];
@endphp
<table class="table admin-table">
    <thead>
    <th>type</th>
    <th>subject</th>
    <th>date</th>
    <th>time</th>
    </thead>
    <tbody>

    @foreach($communications as $communication)

        <tr>
            <td>
                {!! $communication->communicationType->name ?? '' !!}
            </td>
            <td>
                {!! $communication->subject !!}
            </td>
            <td>
                {{ longDate($communication->date) }}
            </td>
            <td>
                {!! $communication->time !!}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
