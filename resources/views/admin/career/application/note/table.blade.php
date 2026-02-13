@php
$notes = $notes ?? [];
@endphp
<table class="table admin-table">
    <thead>
    <th>subject</th>
    <th>body</th>
    <th>time</th>
    </thead>
    <tbody>

    @foreach($notes as $note)

        <tr>
            <td>
                {!! $note->subject !!}
            </td>
            <td>
                {!! $note->body !!}
            </td>
            <td>
                {{ longDateTime($note->created_at) }}
            </td>
        </tr>

    @endforeach

    </tbody>
</table>
