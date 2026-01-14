@php
$notes = $notes ?? [];
@endphp
<table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
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
