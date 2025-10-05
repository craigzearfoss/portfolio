@php
$communications = $communications ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
    <thead>
    <th>subject</th>
    <th>date</th>
    <th>time</th>
    </thead>
    <tbody>

    @foreach($communications as $communication)

        <tr>
            <td>
                {{ $communication['subject'] }}
            </td>
            <td>
                {{ longDate($communication->date) }}
            </td>
            <td>
                {{ $communication->time }}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
